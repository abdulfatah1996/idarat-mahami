<div class="container py-4" wire:poll.10s>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">الإشعارات</h4>
    </div>

    @forelse ($notifications as $notification)
        <div class="card mb-3 shadow-sm @if (!$notification->is_read) border-primary @endif">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-100" style="cursor: pointer;"
                    wire:click="readAndRedirect({{ $notification->id }})">
                    <div
                        class="avatar-md bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="{{ $notification->icon ?? 'ti ti-info-circle' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold text-dark">
                            {{ $notification->title }}
                            @if (!$notification->is_read)
                                <span class="badge bg-primary ms-2">جديد</span>
                            @endif
                        </h5>
                        <p class="mb-1 text-muted">{{ $notification->body }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="text-end ms-2">
                    <button class="btn btn-sm btn-outline-danger"
                        wire:click.stop="deleteNotification({{ $notification->id }})">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">لا توجد إشعارات حالياً.</div>
    @endforelse

    <div class="mt-4 d-flex justify-content-center">
        {{ $notifications->links() }}
    </div>
</div>
