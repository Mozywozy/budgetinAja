<?php

namespace App\Livewire\Budget;

use Livewire\Component;
use App\Models\Budget;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk filter dan pencarian
    public $search = '';
    public $date_from = '';
    public $date_to = '';
    public $status = '';
    public $sortField = 'start_date';
    public $sortDirection = 'desc';

    // Properties untuk form create/edit
    public $showForm = false;
    public $isEditing = false;
    public $budget_id;
    public $total_amount;
    public $start_date;
    public $end_date;
    public $notes;

    // Properties untuk modal konfirmasi hapus
    public $showDeleteModal = false;
    public $budgetToDelete = null;

    // Listeners untuk event
    protected $listeners = ['$refresh'];

    // Rules untuk validasi
    protected $rules = [
        'total_amount' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'notes' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        // $this->date_to = Carbon::now()->addMonths(3)->endOfMonth()->format('Y-m-d');
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->date_from = '';  // Reset ke kosong
        $this->date_to = ''; 
        $this->resetPage();
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['budget_id', 'total_amount', 'notes']);
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->isEditing = false;
    }

    public function edit($budgetId)
    {
        $this->isEditing = true;
        $this->budget_id = $budgetId;

        $budget = Budget::where('id', $budgetId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->total_amount = $budget->total_amount;
        $this->start_date = $budget->start_date->format('Y-m-d');
        $this->end_date = $budget->end_date->format('Y-m-d');
        $this->notes = $budget->notes;

        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $budget = Budget::where('id', $this->budget_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $budget->update([
                'total_amount' => $this->total_amount,
                'currency' => Auth::user()->currency,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'notes' => $this->notes,
            ]);

            // Buat notifikasi untuk update anggaran
            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Anggaran Diperbarui',
                'message' => ($this->notes ?: 'Tanpa Nama') . ' berhasil diperbarui.',
                'type' => 'success',
                'is_read' => false,
            ]);

            $this->dispatch('budgetUpdated');
            $this->dispatch('refresh');
            // Simpan pesan notifikasi di session flash
            session()->flash('notyf_type', 'success');  
            session()->flash('notyf_message', 'Anggaran berhasil diperbarui.');
        } else {
            Budget::create([
                'user_id' => Auth::id(),
                'total_amount' => $this->total_amount,
                'currency' => Auth::user()->currency,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'notes' => $this->notes,
            ]);

            // Buat notifikasi untuk pembuatan anggaran baru
            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Anggaran Baru',
                'message' => ($this->notes ?: 'Tanpa Nama') . ' berhasil dibuat.',
                'type' => 'success',
                'is_read' => false,
            ]);

            $this->dispatch('budgetAdded');
            $this->dispatch('refresh');
            // Simpan pesan notifikasi di session flash
            session()->flash('notyf_type', 'success');
            session()->flash('notyf_message', 'Anggaran berhasil dibuat.');
        }

        $this->closeForm();
        $this->resetPage();
        return redirect(request()->header('Referer'));
    }

    public function confirmDelete($budgetId)
    {
        $this->budgetToDelete = $budgetId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->budgetToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteBudget()
    {
        $budget = Budget::where('id', $this->budgetToDelete)
            ->where('user_id', Auth::id())
            ->first();

        if ($budget) {
            // Check if budget has transactions
            $hasTransactions = $budget->transactions()->exists();

            if ($hasTransactions) {
                session()->flash('error', 'Anggaran tidak dapat dihapus karena masih memiliki transaksi terkait.');
                $this->showDeleteModal = false;
                $this->budgetToDelete = null;
                return;
            }

            $budgetName = $budget->notes ?: 'Tanpa Nama';
            $budget->delete();

            // Buat notifikasi untuk penghapusan anggaran
            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Anggaran Dihapus',
                'message' => 'Anggaran ' . $budgetName . ' berhasil dihapus.',
                'type' => 'info',
                'is_read' => false,
            ]);

            $this->dispatch('budgetDeleted');
            $this->dispatch('refresh');
            // Simpan pesan notifikasi di session flash
            session()->flash('notyf_type', 'info');
            session()->flash('notyf_message', 'Anggaran ' . $budgetName . ' berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->budgetToDelete = null;
        $this->resetPage();
        return redirect(request()->header('Referer'));
    }
    public function updatedSearch()
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

    public function render()
    {
        $budgets = Budget::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                return $query->where('notes', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $now = now();
                switch ($this->status) {
                    case 'active':
                        return $query->where('start_date', '<=', $now)
                                   ->where('end_date', '>=', $now);
                    case 'upcoming':
                        return $query->where('start_date', '>', $now);
                    case 'completed':
                        return $query->where('end_date', '<', $now);
                }
            })
            ->when($this->date_from, function ($query) {
                return $query->where('start_date', '>=', $this->date_from);
            })
            ->when($this->date_to, function ($query) {
                return $query->where('end_date', '<=', $this->date_to);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(9);

        return view('livewire.budget.index', [
            'budgets' => $budgets
        ]);
    }
}
