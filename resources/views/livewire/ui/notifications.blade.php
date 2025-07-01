<li class="dropdown notification-list" wire:poll.10s>
    <a class="nav-link dropdown-toggle nav-icon" data-bs-toggle="dropdown" href="#">
        <i class="ti ti-bell"></i>
        @if ($unreadCount)
            <span class="alert-badge bg-danger rounded-circle animate__animated animate__heartBeat animate__infinite"></span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
        <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
            الإشعارات <span class="badge bg-soft-primary">{{ $unreadCount }}</span>
        </h6>

        <div class="notification-menu" data-simplebar style="max-height: 300px;">
            @forelse($notifications as $notification)
                <a href="#" wire:click.prevent="openAndMarkAsRead({{ $notification->id }})" class="dropdown-item py-3">
                    <small class="float-end text-muted ps-2">{{ $notification->created_at->diffForHumans() }}</small>
                    <div class="media d-flex">
                        <div class="avatar-md bg-soft-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="{{ $notification->icon ?? 'ti ti-info-circle' }}"></i>
                        </div>
                        <div class="media-body ms-2">
                            <h6 class="fw-bold text-dark mb-1">{{ $notification->title }}</h6>
                            <small class="text-muted">{{ $notification->body }}</small>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center p-4 text-muted">لا توجد إشعارات حالياً</div>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}" class="dropdown-item text-center text-primary border-top py-3"
           wire:click="markAllAsRead">
            عرض الكل
        </a>
    </div>
</li>
