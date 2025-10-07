<?php

namespace App\Livewire\Goal;

use Livewire\Component;
use App\Models\Goal;
use App\Models\Notification;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properti untuk daftar goals dan filter
    // public $goals;
    public $search = '';
    public $status = '';
    public $sortField = 'target_date';
    public $sortDirection = 'asc';

    // Properti untuk form create/edit
    public $isOpen = false;
    public $isEdit = false;
    public $goal_id;
    public $name;
    public $target_amount;
    public $current_amount = 0;
    public $target_date;
    public $description;
    public $form_status = 'not_started';

    public $showDeleteModal = false;
    public $goalToDelete = null;

    protected $listeners = ['goalAdded' => 'refreshGoals', 'goalUpdated' => 'refreshGoals', 'goalDeleted' => 'refreshGoals'];

    protected $rules = [
        'name' => 'required|string|max:100',
        'target_amount' => 'required|numeric|min:0',
        'current_amount' => 'required|numeric|min:0',
        'target_date' => 'required|date',
        'description' => 'nullable|string|max:255',
        'form_status' => 'required|in:not_started,in_progress,completed',
    ];

    public function mount()
    {
        $this->target_date = Carbon::now()->addMonths(3)->format('Y-m-d');
        $this->refreshGoals();
    }

    public function refreshGoals()
    {
        $this->goals = Goal::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
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

        $this->refreshGoals();
    }

    public function confirmDelete($goalId)
    {
        $this->goalToDelete = $goalId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->goalToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteGoal($goalId)
    {
        $goal = Goal::where('id', $goalId)
            ->where('user_id', Auth::id())
            ->first();

        if ($goal) {
            $goal->delete();
            $this->dispatch('goalDeleted');
            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Target Dihapus',
                'message' => $goal->name . ' berhasil dihapus.',
                'type' => 'success',
                'is_read' => false,
            ]);
            session()->flash('notyf_type', 'success');
            session()->flash('notyf_message', 'Target berhasil dihapus.');
            return redirect(request()->header('Referer'));
        }
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
            'goal_id',
            'name',
            'target_amount',
            'current_amount',
            'description',
            'isEdit'
        ]);
        $this->form_status = 'not_started';
        $this->target_date = Carbon::now()->addMonths(3)->format('Y-m-d');
    }

    public function updatedCurrentAmount()
    {
        if ($this->current_amount > 0 && $this->current_amount < $this->target_amount) {
            $this->form_status = 'in_progress';
        } elseif ($this->current_amount >= $this->target_amount) {
            $this->form_status = 'completed';
        } else {
            $this->form_status = 'not_started';
        }
    }

    public function save()
    {
        $this->validate();

        Goal::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'target_amount' => $this->target_amount,
            'current_amount' => $this->current_amount,
            'target_date' => $this->target_date,
            'description' => $this->description,
            'status' => $this->form_status,
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Target Baru',
            'message' => $this->name . ' berhasil dibuat.',
            'type' => 'success',
            'is_read' => false,
        ]);

        $this->closeModal();
        $this->resetForm();
        $this->dispatch('goalAdded');
        session()->flash('notyf_type', 'success');
        session()->flash('notyf_message', 'Target berhasil dibuat.');
        return redirect(request()->header('Referer'));
    }

    public function edit($id)
    {
        $goal = Goal::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->goal_id = $goal->id;
        $this->name = $goal->name;
        $this->target_amount = $goal->target_amount;
        $this->current_amount = $goal->current_amount;
        $this->target_date = $goal->target_date->format('Y-m-d');
        $this->description = $goal->description;
        $this->form_status = $goal->status;

        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate();

        $goal = Goal::where('id', $this->goal_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $goal->update([
            'name' => $this->name,
            'target_amount' => $this->target_amount,
            'current_amount' => $this->current_amount,
            'target_date' => $this->target_date,
            'description' => $this->description,
            'status' => $this->form_status,
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Target Diperbarui',
            'message' => $this->name . ' berhasil diperbarui.',
            'type' => 'success',
            'is_read' => false,
        ]);

        $this->closeModal();
        $this->resetForm();
        $this->dispatch('goalUpdated');
        session()->flash('notyf_type', 'success');
        session()->flash('notyf_message', 'Target berhasil diperbarui.');
        return redirect(request()->header('Referer'));
    }

    // Tambahkan metode ini sebelum metode render()
    
    public function updatedSearch()
    {
        $this->refreshGoals();
    }
    
    public function updatedStatus()
    {
        $this->refreshGoals();
    }

    public function render()
    {
        $goals = Goal::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                return $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.goal.index', compact('goals'));
    }
}
