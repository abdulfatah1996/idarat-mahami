<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class Notifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = ['refreshNotifications' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $this->unreadCount = $notifications->where('is_read', false)->count();
        $this->notifications = $notifications;
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadNotifications();
    }

    public function openAndMarkAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['is_read' => true]);
            $this->loadNotifications();
            return redirect()->to($notification->url ?? '/');
        }
    }
    public function render()
    {
        return view('livewire.ui.notifications');
    }
}
