<?php

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function readAndRedirect($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
            return redirect()->to($notification->url ?? '/');
        }
    }

    public function deleteNotification($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function render()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.notifications.index', compact('notifications'));
    }
}
