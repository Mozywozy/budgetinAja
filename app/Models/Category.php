<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'icon',
        'color',
        'budget_limit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'budget_limit' => 'decimal:2',
    ];

    /**
     * Get the user that owns the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculate the total spent in this category for the current month.
     */
    public function getCurrentMonthSpentAttribute()
    {
        $now = now();
        return $this->transactions()
            ->where('type', 'expense')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
    }

    public function isAtOrOverLimit()
    {
        if (!$this->budget_limit) {
            return false;
        }

        $spent = $this->current_month_spent;
        return ($spent / $this->budget_limit) >= 1.0;
    }

    /**
     * Check if the category is approaching its budget limit.
     */
    public function isApproachingLimit()
    {
        if (!$this->budget_limit) {
            return false;
        }

        $spent = $this->current_month_spent;
        return ($spent / $this->budget_limit) >= 0.8;
    }
}