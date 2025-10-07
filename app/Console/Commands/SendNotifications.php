<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat pembayaran dan batas anggaran';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $this->info('Mengirim notifikasi...');
        $notificationService->sendPaymentReminders();
        $this->info('Notifikasi berhasil dikirim!');
        
        return Command::SUCCESS;
    }
}