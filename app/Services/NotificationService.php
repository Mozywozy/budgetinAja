<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Kirim notifikasi pengingat pembayaran
     */
    public function sendPaymentReminders()
    {
        $users = User::where('notification_enabled', true)->get();
        
        foreach ($users as $user) {
            // Cek transaksi berulang yang perlu diingatkan
            $this->checkRecurringPayments($user);
            
            // Cek budget yang hampir habis
            $this->checkBudgetLimits($user);
            
            // Cek kategori yang hampir mencapai batas
            $this->checkCategoryLimits($user);
        }
    }
    
    /**
     * Cek pembayaran berulang yang perlu diingatkan
     */
    private function checkRecurringPayments(User $user)
    {
        // Dapatkan transaksi dengan pola berulang (misalnya tagihan bulanan)
        $recurringDescriptions = ['tagihan', 'langganan', 'subscription', 'bill', 'bayar'];
        
        // Cari transaksi bulan lalu dengan pola berulang
        $lastMonth = Carbon::now()->subMonth();
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $lastMonth->month)
            ->whereYear('transaction_date', $lastMonth->year)
            ->get();
            
        foreach ($transactions as $transaction) {
            // Cek apakah deskripsi mengandung kata-kata yang menunjukkan pembayaran berulang
            $isRecurring = false;
            foreach ($recurringDescriptions as $term) {
                if (stripos($transaction->description, $term) !== false) {
                    $isRecurring = true;
                    break;
                }
            }
            
            if ($isRecurring) {
                // Cek apakah sudah ada transaksi serupa bulan ini
                $thisMonth = Carbon::now();
                $similarTransactionExists = Transaction::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->where('category_id', $transaction->category_id)
                    ->whereMonth('transaction_date', $thisMonth->month)
                    ->whereYear('transaction_date', $thisMonth->year)
                    ->where('description', 'like', '%' . $transaction->description . '%')
                    ->exists();
                    
                if (!$similarTransactionExists) {
                    // Buat notifikasi pengingat pembayaran
                    $dueDate = Carbon::now()->endOfMonth()->format('d M Y');
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => 'Pengingat Pembayaran',
                        'message' => "Sepertinya Anda belum melakukan pembayaran untuk '{$transaction->description}' bulan ini. Jatuh tempo: {$dueDate}.",
                        'type' => 'warning',
                        'is_read' => false,
                    ]);
                }
            }
        }
    }
    
    /**
     * Cek budget yang hampir mencapai batas
     */
    private function checkBudgetLimits(User $user)
    {
        // Dapatkan budget aktif
        $activeBudgets = Budget::where('user_id', $user->id)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->get();
            
        foreach ($activeBudgets as $budget) {
            $spent = $budget->transactions()->where('type', 'expense')->sum('amount');
            $percentage = ($spent / $budget->total_amount) * 100;
            
            // Notifikasi jika pengeluaran mencapai 75% dari budget
            if ($percentage >= 75 && $percentage < 90) {
                // Cek apakah sudah ada notifikasi serupa yang belum dibaca
                $existingNotification = Notification::where('user_id', $user->id)
                    ->where('title', 'Pengingat Anggaran')
                    ->where('is_read', false)
                    ->where('created_at', '>=', Carbon::now()->subDays(3))
                    ->where('message', 'like', '%' . $budget->notes . '%')
                    ->exists();
                    
                if (!$existingNotification) {
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => 'Pengingat Anggaran',
                        'message' => "Anggaran '{$budget->notes}' Anda sudah mencapai {$percentage}% dari total. Harap berhati-hati dengan pengeluaran Anda.",
                        'type' => 'warning',
                        'is_read' => false,
                    ]);
                }
            }
            // Notifikasi jika pengeluaran mencapai 90% dari budget
            elseif ($percentage >= 90) {
                // Cek apakah sudah ada notifikasi serupa yang belum dibaca
                $existingNotification = Notification::where('user_id', $user->id)
                    ->where('title', 'Peringatan Anggaran')
                    ->where('is_read', false)
                    ->where('created_at', '>=', Carbon::now()->subDays(2))
                    ->where('message', 'like', '%' . $budget->notes . '%')
                    ->exists();
                    
                if (!$existingNotification) {
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => 'Peringatan Anggaran',
                        'message' => "Anggaran '{$budget->notes}' Anda sudah mencapai {$percentage}% dari total. Anda hampir melampaui batas anggaran!",
                        'type' => 'alert',
                        'is_read' => false,
                    ]);
                }
            }
        }
    }
    
    /**
     * Cek kategori yang hampir mencapai batas
     */
    private function checkCategoryLimits(User $user)
    {
        // Dapatkan kategori dengan budget_limit
        $categories = Category::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereNotNull('budget_limit')
            ->get();
            
        $now = Carbon::now();
        
        foreach ($categories as $category) {
            // Hitung pengeluaran bulan ini untuk kategori tersebut
            $spent = Transaction::where('user_id', $user->id)
                ->where('category_id', $category->id)
                ->where('type', 'expense')
                ->whereYear('transaction_date', $now->year)
                ->whereMonth('transaction_date', $now->month)
                ->sum('amount');
                
            $percentage = ($spent / $category->budget_limit) * 100;
            
            // Notifikasi jika pengeluaran mencapai 80% dari batas kategori
            if ($percentage >= 80 && $percentage < 100) {
                // Cek apakah sudah ada notifikasi serupa yang belum dibaca
                $existingNotification = Notification::where('user_id', $user->id)
                    ->where('title', 'Batas Kategori Hampir Tercapai')
                    ->where('is_read', false)
                    ->where('created_at', '>=', Carbon::now()->subDays(3))
                    ->where('message', 'like', '%' . $category->name . '%')
                    ->exists();
                    
                if (!$existingNotification) {
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => 'Batas Kategori Hampir Tercapai',
                        'message' => "Pengeluaran untuk kategori '{$category->name}' telah mencapai {$percentage}% dari batas yang ditentukan.",
                        'type' => 'warning',
                        'is_read' => false,
                    ]);
                }
            }
            // Notifikasi jika pengeluaran melebihi batas kategori
            elseif ($percentage >= 100) {
                // Cek apakah sudah ada notifikasi serupa yang belum dibaca
                $existingNotification = Notification::where('user_id', $user->id)
                    ->where('title', 'Batas Kategori Terlampaui')
                    ->where('is_read', false)
                    ->where('created_at', '>=', Carbon::now()->subDays(2))
                    ->where('message', 'like', '%' . $category->name . '%')
                    ->exists();
                    
                if (!$existingNotification) {
                    Notification::create([
                        'user_id' => $user->id,
                        'title' => 'Batas Kategori Terlampaui',
                        'message' => "Pengeluaran untuk kategori '{$category->name}' telah melebihi batas yang ditentukan.",
                        'type' => 'alert',
                        'is_read' => false,
                    ]);
                }
            }
        }
    }
}