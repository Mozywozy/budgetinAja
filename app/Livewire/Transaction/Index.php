<?php

namespace App\Livewire\Transaction;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Budget;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use \Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination;
    use \Livewire\WithFileUploads;

    protected $paginationTheme = 'tailwind';

    // Properti untuk daftar transaksi dan filter
    // Hapus property $transactions karena akan diganti dengan pagination
    public $search = '';
    public $type = '';
    public $category_id = '';
    public $date_from = '';
    public $date_to = '';
    public $sortField = 'transaction_date';
    public $sortDirection = 'desc';
    public $categories;

    // Properti untuk form create/edit
    public $isOpen = false;
    public $isEdit = false;
    public $transaction_id;
    public $form_type = 'expense';
    public $amount;
    public $description;
    public $transaction_date;
    public $form_category_id;
    public $budget_id;
    public $attachment;
    public $current_attachment;
    public $budgets = [];
    public $form_categories = [];

    public $showDeleteModal = false;
    public $transactionToDelete = null;

    protected $listeners = ['transactionAdded' => 'refreshTransactions', 'transactionUpdated' => 'refreshTransactions', 'transactionDeleted' => 'refreshTransactions'];

    protected $rules = [
        'form_type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:0',
        'description' => 'required|string|max:255',
        'transaction_date' => 'required|date',
        'form_category_id' => 'required|exists:categories,id',
        'budget_id' => 'required|exists:budgets,id',
        'attachment' => 'nullable|file|max:2048',
    ];

    public function mount()
    {
        $this->categories = Category::where('user_id', Auth::id())->get();
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
        $this->transaction_date = Carbon::now()->format('Y-m-d');
        // Hapus $this->refreshTransactions();
        $this->loadFormCategories();
        $this->loadBudgets();
    }

    public function refreshTransactions()
    {
        $this->transactions = Transaction::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                return $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })
            ->when($this->date_from, function ($query) {
                return $query->where('transaction_date', '>=', $this->date_from);
            })
            ->when($this->date_to, function ($query) {
                return $query->where('transaction_date', '<=', $this->date_to);
            })
            ->with('category')
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        // Hapus $this->refreshTransactions();
    }

    public function confirmDelete($transactionId)
    {
        $this->transactionToDelete = $transactionId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->transactionToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteTransaction()
    {
        $transaction = Transaction::where('id', $this->transactionToDelete)
            ->where('user_id', Auth::id())
            ->first();

        if ($transaction) {
            // Hapus attachment jika ada
            if ($transaction->attachment && Storage::disk('public')->exists($transaction->attachment)) {
                Storage::disk('public')->delete($transaction->attachment);
            }

            $transactionName = $transaction->description ?: 'Tanpa Nama';
            $transaction->delete();
            // Buat notifikasi untuk penghapusan transaksi
            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Transaksi Dihapus',
                'message' => $transactionName . ' berhasil dihapus.',
                'type' => 'success',
                'is_read' => false,
            ]);
            $this->dispatch('transactionDeleted');
            session()->flash('notyf_type', 'success');
            session()->flash('notyf_message', $transactionName . ' berhasil dihapus.');
            return redirect(request()->header('Referer'));
        }
    }

    // tombol reset
    public function resetFilters()
    {
        $this->reset(['search', 'type', 'category_id']);
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
        $this->refreshTransactions();
    }

    // Metode untuk form create/edit
    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetForm()
    {
        $this->reset([
            'transaction_id',
            'form_type',
            'amount',
            'description',
            'attachment',
            'current_attachment',
            'isEdit'
        ]);
        $this->transaction_date = Carbon::now()->format('Y-m-d');
        $this->loadFormCategories();
        $this->loadBudgets();
    }

    public function loadFormCategories()
    {
        $this->form_categories = Category::where('user_id', Auth::id())
            ->where('type', $this->form_type)
            ->get();

        // Reset form_category_id if no matching categories
        if ($this->form_categories->isEmpty()) {
            $this->form_category_id = null;
        } else if (!$this->form_category_id || !$this->form_categories->contains('id', $this->form_category_id)) {
            $this->form_category_id = $this->form_categories->first()->id;
        }
    }

    public function loadBudgets()
    {
        $this->budgets = Budget::where('user_id', Auth::id())
            ->where('start_date', '<=', $this->transaction_date)
            ->where('end_date', '>=', $this->transaction_date)
            ->get();

        // Reset budget_id if no matching budgets
        if ($this->budgets->isEmpty()) {
            $this->budget_id = null;
        } else if (!$this->budget_id || !$this->budgets->contains('id', $this->budget_id)) {
            $this->budget_id = $this->budgets->first()->id;
        }
    }

    public function updatedFormType()
    {
        $this->loadFormCategories();
    }

    public function updatedTransactionDate()
    {
        $this->loadBudgets();
    }

    public function save()
    {
        $this->validate([
            'form_type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'form_category_id' => 'required|exists:categories,id',
            'budget_id' => 'required|exists:budgets,id',
            'attachment' => 'nullable|file|max:2048',
        ]);

        // Cek sisa anggaran jika transaksi adalah pengeluaran
        if ($this->form_type === 'expense') {
            $budget = Budget::find($this->budget_id);
            if ($budget) {
                $remaining = $budget->remaining;
                if ($this->amount > $remaining) {
                    $this->dispatch('showAlert', [
                        'type' => 'error',
                        'message' => 'Transaksi tidak dapat dilakukan karena melebihi sisa anggaran. Sisa anggaran: ' . number_format($remaining, 0, ',', '.')
                    ]);
                    return;
                }
            }

            // Cek limit budget
            $category = Category::find($this->form_category_id);
            if ($category && $category->isAtOrOverLimit()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Batas pengeluaran sudah tercapai. Transaksi tidak dapat dilakukan.'
                ]);
                return;
            }
        }

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('attachments', 'public');
        }

        // Buat transaksi
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'type' => $this->form_type,
            'amount' => $this->amount,
            'description' => $this->description,
            'transaction_date' => $this->transaction_date,
            'category_id' => $this->form_category_id,
            'budget_id' => $this->budget_id,
            'attachment' => $attachmentPath,
        ]);

        // Perbarui budget jika transaksi berhasil dibuat
        if ($transaction) {
            $budget = Budget::find($this->budget_id);
            if ($budget) {
                // Jika pemasukan, tambahkan ke total_amount budget
                if ($this->form_type === 'income') {
                    $budget->total_amount += $this->amount;
                    $budget->save();
                }
            }
        }

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Transaksi Berhasil',
            'message' => 'Transaksi ' . ($this->form_type === 'income' ? 'pemasukan' : 'pengeluaran') . ' sebesar ' . number_format($this->amount, 0, ',', '.') . ' berhasil ditambahkan.',
            'type' => 'success',
        ]);

        $this->resetForm();
        $this->isOpen = false;
        $this->dispatch('notyf:success', ['message' => 'Transaksi berhasil ditambahkan']);
        $this->refreshTransactions();
    }

    public function edit($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->transaction_id = $transaction->id;
        $this->form_type = $transaction->type;
        $this->amount = $transaction->amount;
        $this->description = $transaction->description;
        $this->transaction_date = $transaction->transaction_date->format('Y-m-d');
        $this->form_category_id = $transaction->category_id;
        $this->budget_id = $transaction->budget_id;
        $this->current_attachment = $transaction->attachment;

        $this->loadFormCategories();
        $this->loadBudgets();

        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate();

        // Cek sisa anggaran jika transaksi adalah pengeluaran
        if ($this->form_type === 'expense') {
            $budget = Budget::find($this->budget_id);
            if ($budget) {
                // Ambil transaksi yang sedang diedit untuk menghitung sisa anggaran yang benar
                $currentTransaction = Transaction::find($this->transaction_id);
                $remaining = $budget->remaining;
                
                // Jika ini adalah transaksi pengeluaran yang sudah ada, tambahkan jumlah sebelumnya ke remaining
                if ($currentTransaction && $currentTransaction->type === 'expense') {
                    $remaining += $currentTransaction->amount;
                }

                if ($this->amount > $remaining) {
                    $this->dispatch('showAlert', [
                        'type' => 'error',
                        'message' => 'Transaksi tidak dapat dilakukan karena melebihi sisa anggaran. Sisa anggaran: ' . number_format($remaining, 0, ',', '.')
                    ]);
                    return;
                }
            }

            // Cek limit budget
            $category = Category::find($this->form_category_id);
            if ($category && $category->isAtOrOverLimit()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Batas pengeluaran sudah tercapai. Transaksi tidak dapat dilakukan.'
                ]);
                return;
            }
        }

        try {
            $transaction = Transaction::where('id', $this->transaction_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $attachmentPath = $this->current_attachment;
            if ($this->attachment) {
                // Delete old attachment if exists
                if ($this->current_attachment && Storage::disk('public')->exists($this->current_attachment)) {
                    Storage::disk('public')->delete($this->current_attachment);
                }
                $attachmentPath = $this->attachment->store('attachments', 'public');
            }

            $transaction->update([
                'type' => $this->form_type,
                'amount' => $this->amount,
                'description' => $this->description,
                'transaction_date' => $this->transaction_date,
                'category_id' => $this->form_category_id,
                'budget_id' => $this->budget_id,
                'attachment' => $attachmentPath,
            ]);

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Transaksi Diperbarui',
                'message' => ($this->description ?: 'Tanpa Nama') . ' berhasil diperbarui.',
                'type' => 'success',
                'is_read' => false,
            ]);

            $this->closeModal();
            $this->resetForm();
            $this->dispatch('transactionUpdated');
            $this->dispatch('refresh');
            session()->flash('notyf_type', 'success');
            session()->flash('notyf_message', 'Transaksi berhasil diperbarui.');

            // Gunakan redirect hanya jika diperlukan
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedFormCategoryId()
    {
        if ($this->form_type === 'expense' && $this->form_category_id) {
            $category = Category::find($this->form_category_id);
            if ($category && $category->isAtOrOverLimit()) {
                $this->dispatch('showAlert', [
                    'type' => 'warning',
                    'message' => 'Batas pengeluaran sudah tercapai. Transaksi masih dapat disimpan, tetapi akan melebihi batas yang ditentukan.'
                ]);
            }
        }
    }

    public function render()
    {
        $transactions = \App\Models\Transaction::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->when($this->search, function ($query) {
                return $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })
            ->when($this->date_from, function ($query) {
                return $query->where('transaction_date', '>=', $this->date_from);
            })
            ->when($this->date_to, function ($query) {
                return $query->where('transaction_date', '<=', $this->date_to);
            })
            ->with(['category', 'budget'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.transaction.index', [
            'transactions' => $transactions
        ]);
    }

    // tombol download excel
    public function exportToExcel()
    {
        $fileName = 'transaksi_' . date('Y-m-d') . '.xlsx';

        $this->dispatch('showLoading', ['message' => 'Sedang mengunduh data...']);

        return Excel::download(
            new TransactionsExport(
                Auth::id(),
                $this->date_from,
                $this->date_to,
                $this->search,
                $this->type,
                $this->category_id
            ),
            $fileName
        );
    }

    // Properti untuk import file (dibutuhkan oleh wire:model di view)
    public $import_file;

    // tombol download template
    public function downloadTemplate()
    {
        $fileName = 'template_transaksi.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TemplateTransactionsExport(\Illuminate\Support\Facades\Auth::id()),
            $fileName
        );
    }

    // tombol import file
    // Import akan otomatis jalan saat file dipilih
    public function updatedImportFile()
    {
        $this->importFile();
    }

    public function importFile()
    {
        $this->validate([
            'import_file' => 'required|file|mimes:xlsx,xls|max:20480',
        ]);

        $path = $this->import_file->store('imports', 'public');

        $import = new \App\Imports\TransactionsImport(\Illuminate\Support\Facades\Auth::id());

        try {
            \Maatwebsite\Excel\Facades\Excel::import($import, \Illuminate\Support\Facades\Storage::disk('public')->path($path));
            $summary = $import->getSummary();
            session()->flash('notyf_type', 'success');
            session()->flash('notyf_message', "Import selesai: {$summary['inserted']} baris berhasil, {$summary['skipped']} baris dilewati.");
            Notification::create([
                'type' => 'success',
                'message' => "Import selesai: {$summary['inserted']} baris berhasil, {$summary['skipped']} baris dilewati."
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }

        // Reset file agar siap untuk import berikutnya
        $this->import_file = null;

        // Pastikan tabel ter-update (tanpa redirect)
        $this->resetPage();
        // Livewire akan otomatis re-render dengan query terbaru di render()
        $this->dispatch('refresh');
        return redirect(request()->header('Referer'));
    }
}
