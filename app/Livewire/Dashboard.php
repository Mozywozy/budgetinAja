<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Budget;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Goal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $currentMonthBudget;
    public $totalIncome;
    public $totalExpense;
    public $remainingBudget;
    public $recentTransactions;
    public $topExpenseCategories;
    public $upcomingGoals;
    public $budgetUtilizationPercentage;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // Get current month budget
        $this->currentMonthBudget = Budget::where('user_id', $userId)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        // Calculate income and expense for current month
        $this->totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        $this->totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        // Calculate remaining budget
        if ($this->currentMonthBudget) {
            $this->remainingBudget = $this->currentMonthBudget->total_amount - $this->totalExpense;
            $this->budgetUtilizationPercentage = $this->currentMonthBudget->total_amount > 0 
                ? ($this->totalExpense / $this->currentMonthBudget->total_amount) * 100 
                : 0;
        } else {
            $this->remainingBudget = 0;
            $this->budgetUtilizationPercentage = 0;
        }

        // Get recent transactions
        $this->recentTransactions = Transaction::where('user_id', $userId)
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // Get top expense categories
        $this->topExpenseCategories = Category::where('user_id', $userId)
            ->where('type', 'expense')
            ->withSum(['transactions' => function ($query) use ($now) {
                $query->where('type', 'expense')
                    ->whereYear('transaction_date', $now->year)
                    ->whereMonth('transaction_date', $now->month);
            }], 'amount')
            ->orderByDesc('transactions_sum_amount')
            ->limit(5)
            ->get();

        // Get upcoming goals
        $this->upcomingGoals = Goal::where('user_id', $userId)
            ->where('status', '!=', 'completed')
            ->orderBy('target_date')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
