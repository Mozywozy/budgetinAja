<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Notification; 
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Hapus property $categories
    public $search = '';
    public $type = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Properties for create/edit form
    public $categoryId;
    public $name = '';
    public $icon = 'default';
    public $color = '#3B82F6';
    public $budget_limit;
    public $isEditing = false;
    public $showModal = false;

    public $showDeleteModal = false;
    public $categoriesToDelete = null;

    protected $listeners = ['categoryAdded' => 'refreshCategories', 'categoryUpdated' => 'refreshCategories', 'categoryDeleted' => 'refreshCategories'];

    protected $rules = [
        'name' => 'required|string|max:50',
        'type' => 'required|in:income,expense',
        'icon' => 'required|string|max:50',
        'color' => 'required|string|max:20',
        'budget_limit' => 'nullable|numeric|min:0',
    ];

    public function mount()
    {
        // Tidak perlu memanggil refreshCategories() lagi
        // Set default sorting ke created_at descending agar kategori baru muncul di awal
        $this->sortField = 'created_at';
        $this->sortDirection = 'desc';
    }

    // Hapus metode refreshCategories()

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        // Tidak perlu memanggil refreshCategories() lagi
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($categoryId)
    {
        $category = Category::where('id', $categoryId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->type = $category->type;
        $this->icon = $category->icon;
        $this->color = $category->color;
        $this->budget_limit = $category->budget_limit;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Only expense categories can have budget limits
        if ($this->type === 'income') {
            $this->budget_limit = null;
        }

        if ($this->isEditing) {
            $category = Category::where('id', $this->categoryId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $category->update([
                'name' => $this->name,
                'type' => $this->type,
                'icon' => $this->icon,
                'color' => $this->color,
                'budget_limit' => $this->budget_limit,
            ]);

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Kategori Diperbarui',
                'message' => $this->name . ' berhasil diperbarui.',
                'type' => 'success',
                'is_read' => false,
            ]);

            $this->dispatch('categoryUpdated');
            $this->dispatch('refresh');
            session()->flash('notyf_type', 'success');  
            session()->flash('notyf_message', 'Kategori berhasil diperbarui.');
        } else {
            Category::create([
                'user_id' => Auth::id(),
                'name' => $this->name,
                'type' => $this->type,
                'icon' => $this->icon,
                'color' => $this->color,
                'budget_limit' => $this->budget_limit,
            ]);

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Kategori Ditambahkan',
                'message' => $this->name . ' berhasil ditambahkan.',
                'type' => 'success',
                'is_read' => false,
            ]);

            $this->dispatch('categoryAdded');
            $this->dispatch('refresh');
            session()->flash('notyf_type', 'success');  
            session()->flash('notyf_message', 'Kategori berhasil dibuat.');
        }

        $this->resetForm();
        $this->showModal = false;
        return redirect(request()->header('Referer'));
        // Hapus $this->refreshCategories();
    }

    public function confirmDelete($categoryId)
    {
        $this->categoriesToDelete = $categoryId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->categoriesToDelete = null;
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::where('id', $categoryId)
            ->where('user_id', Auth::id())
            ->first();
    
        if ($category) {
            // Perbaikan: Gunakan count() untuk memeriksa jumlah transaksi
            $transactionCount = $category->transactions()->count();
            
            // Debug: Tambahkan log untuk memeriksa jumlah transaksi
            \Illuminate\Support\Facades\Log::info("Mencoba menghapus kategori ID: {$categoryId}, Jumlah transaksi: {$transactionCount}");
            
            if ($transactionCount > 0) {
                // Ubah dari session()->flash('error') menjadi session()->flash('notyf_type') dan session()->flash('notyf_message')
                session()->flash('notyf_type', 'error');
                session()->flash('notyf_message', 'Kategori "' . $category->name . '" tidak dapat dihapus karena masih memiliki ' . $transactionCount . ' transaksi terkait.');
                $this->showDeleteModal = false;
                $this->categoriesToDelete = null;
                return redirect(request()->header('Referer'));
            }
    
            try {
                $categoryName = $category->name;
                $category->delete();
                // Buat notifikasi sebelum menghapus
                Notification::create([
                    'user_id' => Auth::id(),
                    'title' => 'Kategori Dihapus',
                    'message' => $categoryName . ' berhasil dihapus.',
                    'type' => 'success',
                    'is_read' => false,
                ]);

                $this->dispatch('categoryDeleted');
                $this->dispatch('refresh');
                session()->flash('notyf_type', 'success');  
                session()->flash('notyf_message', 'Kategori berhasil dihapus.');
            } catch (\Exception $e) {
                // Tangkap error jika terjadi masalah saat menghapus
                \Illuminate\Support\Facades\Log::error("Error saat menghapus kategori: " . $e->getMessage());
                session()->flash('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'Kategori tidak ditemukan.');
        }
        $this->showDeleteModal = false;
        $this->categoriesToDelete = null;
        session()->flash('notyf_type', 'info');  
        session()->flash('notyf_message', 'Kategori berhasil dihapus.');
        return redirect(request()->header('Referer'));
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->type = 'expense';
        $this->icon = 'default';
        $this->color = '#3B82F6';
        $this->budget_limit = null;
        $this->isEditing = false;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.category.index', [
            'categories' => $categories
        ]);
    }
}
