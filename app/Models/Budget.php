<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'currency',
        'start_date',
        'end_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the budget.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the budget.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculate the remaining budget amount.
     */
    public function getRemainingAttribute()
    {
        // Gunakan query builder untuk menghindari masalah dengan properti 'type'
        $spent = DB::table('transactions')
            ->where('budget_id', $this->id)
            ->where('type', 'expense')
            ->sum('amount');
        
        return $this->total_amount - $spent;
    }

    protected $appends = ['status', 'remaining'];

    /**
     * Get the status of the budget.
     */
    public function getStatusAttribute()
    {
        $now = now();
        
        if ($this->start_date > $now) {
            return 'upcoming'; // Akan datang
        } elseif ($this->end_date < $now) {
            return 'completed'; // Selesai
        } else {
            return 'active'; // Aktif
        }
    }
}