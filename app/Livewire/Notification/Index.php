<?php

namespace App\Livewire\Notification;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $notifications;
    public $unreadCount;

    protected $listeners = ['notificationRead' => 'refreshNotifications', 'notificationMarkedAsRead' => 'refreshNotifications'];

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function refreshNotifications()
    {
        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $this->unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->markAsRead();
            session()->flash('notyf_type', 'success');  
            session()->flash('notyf_message', 'Notifikasi berhasil ditandai sebagai dibaca.');
            return redirect(request()->header('Referer'));
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('notificationMarkedAsRead');
        session()->flash('notyf_type', 'success');  
        session()->flash('notyf_message', 'Semua notifikasi telah ditandai sebagai dibaca.');
        return redirect(request()->header('Referer'));
    }

    public function deleteNotification($notificationId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->delete();
            $this->refreshNotifications();
            session()->flash('notyf_type', 'success');  
            session()->flash('notyf_message', 'Notifikasi berhasil dihapus.');
            return redirect(request()->header('Referer'));
        }
    }
    
    public function deleteAllNotifications()
    {
        Notification::where('user_id', Auth::id())->delete();
        
        $this->refreshNotifications();
        session()->flash('notyf_type', 'success');  
        session()->flash('notyf_message', 'Semua notifikasi berhasil dihapus.');
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.notification.index');
    }
}
