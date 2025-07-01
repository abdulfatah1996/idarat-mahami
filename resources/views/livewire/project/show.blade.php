<div class="container-fluid">
    {{-- إشعار --}}
    @if ($showToast)
        @php
            $style = [
                'bg' => $type === 'success' ? '#d4edda' : ($type === 'error' ? '#f8d7da' : '#fff3cd'),
                'text' => $type === 'success' ? '#155724' : ($type === 'error' ? '#721c24' : '#856404'),
                'icon' =>
                    $type === 'success'
                        ? 'fas fa-check-circle text-success'
                        : ($type === 'error'
                            ? 'fas fa-exclamation-triangle text-danger'
                            : 'fas fa-info-circle text-warning'),
            ];
        @endphp
        <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1080;" wire:poll.3s="hideToast">
            <div class="toast show d-flex align-items-center border-0 shadow-lg rounded-3 px-4 py-3"
                style="min-width: 320px; background-color: {{ $style['bg'] }}; color: {{ $style['text'] }}; font-weight: 500;">
                <i class="{{ $style['icon'] }} me-3 fs-4"></i>
                <div class="toast-body p-0 flex-grow-1">
                    {{ $message }}
                </div>
            </div>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">تفاصيل المشروع</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">المشاريع</a></li>
                    <li class="breadcrumb-item active">{{ $project->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    @php
        $statusColors = [
            'new' => 'primary',
            'in_progress' => 'warning',
            'completed' => 'success',
        ];

        $statusLabels = [
            'new' => 'جديد',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
        ];

        $priorityColors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
        ];

        $priorityLabels = [
            'low' => 'منخفضة',
            'medium' => 'متوسطة',
            'high' => 'عالية',
        ];
    @endphp

    <div class="card shadow-sm border rounded-3 mb-4">
        <div class="card-body position-relative">

            <!-- الحالة والأولوية في الأعلى -->
            <div class="d-flex justify-content-end gap-2 mb-3">
                <span class="badge rounded-pill badge-soft-{{ $statusColors[$project->status] ?? 'secondary' }}">
                    <i class="fas fa-circle me-1 text-{{ $statusColors[$project->status] ?? 'secondary' }} small"></i>
                    {{ $statusLabels[$project->status] ?? 'غير معروف' }}
                </span>
                <span class="badge rounded-pill badge-soft-{{ $priorityColors[$project->priority] ?? 'secondary' }}">
                    <i class="fas fa-flag me-1 text-{{ $priorityColors[$project->priority] ?? 'secondary' }}"></i>
                    {{ $priorityLabels[$project->priority] ?? 'غير محددة' }}
                </span>
            </div>

            <!-- عنوان المشروع -->
            <h4 class="fw-bold text-primary mb-2 d-flex align-items-center">
                <i class="las la-folder-open me-2 text-primary fs-4"></i>
                {{ $project->name }} ({{ $project->number }})
            </h4>
            <!-- اسم العميل -->
            <h5 class="text-muted mb-3">
                العميل:
                {{ $project->client_name ?: 'لا يوجد اسم عميل محدد' }}
            </h5>

            <!-- شريط نسبة الإنجاز -->
            <div class="progress mb-3" style="height: 6px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $project->progress }}%;"
                    aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>

            <!-- نسبة رقمية -->
            <small class="text-muted">{{ $project->progress }}% مكتمل</small>


            <!-- وصف -->
            <p class="text-muted mb-3">
                {{ $project->description ?: 'لا يوجد وصف متاح لهذا المشروع.' }}
            </p>

            <!-- معلومات سريعة -->
            <div class="row text-muted mb-4">
                <div class="col-md-4 mb-2">
                    <i class="far fa-calendar-alt me-1"></i> بدأ:
                    <span class="fw-semibold">{{ $project->created_at->diffForHumans() }}</span>
                </div>
                <div class="col-md-4 mb-2">
                    <i class="far fa-calendar-check me-1"></i> انتهاء:
                    <span class="fw-semibold">
                        ينتهي بعد
                        {{ $project->end_date ? $project->end_date->diffForHumans() : 'غير محدد' }}
                    </span>
                </div>
                <div class="col-md-4 mb-2">
                    <i class="fas fa-dollar-sign me-1"></i> الموازنة:
                    <span class="fw-semibold text-success">${{ number_format($project->budget, 2) }}</span>
                </div>
            </div>

            <!-- المالك -->
            <div class="d-flex align-items-center gap-3 py-2 mb-4">
                <img src="{{ $project->owner->avatar_url ?? asset('assets/images/users/default.jpg') }}"
                    alt="صورة المستخدم" class="rounded-circle shadow-sm" width="50" height="50">
                <div>
                    <div class="fw-semibold text-dark">{{ $project->owner->name }}</div>
                    <small class="text-muted">{{ $project->owner->email }}</small>
                </div>
            </div>
            <div class="col-md-12">
                <div class="bg-light p-3">
                    <div class="dropdown d-inline-block float-end mt-n2">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" wire:click="ShowCreateTaskModal">
                            <i class="las la-plus-circle ms-1"></i>
                            أضافة مهمة جديدة
                        </button>
                        <!-- Modal -->
                        @if ($createTaskModal)
                            <div id="createTaskModal" class="modal fade show d-block" tabindex="-1"
                                style="background-color: rgba(0,0,0,0.5); display: block;" aria-modal="true"
                                role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">

                                        <!-- Header -->
                                        <div class="modal-header bg-white border-bottom py-3">
                                            <h5 class="modal-title text-dark fw-bold">
                                                <i class="las la-plus-circle text-primary me-2 fs-4"></i>
                                                إنشاء مهمة جديدة
                                            </h5>
                                            <button type="button" class="btn-close"
                                                wire:click="$set('createTaskModal', false)"></button>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body bg-light p-4">
                                            <form wire:submit.prevent="createTask"
                                                class="bg-white rounded-3 p-4 shadow-sm">

                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">عنوان المهمة</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="las la-pen"></i></span>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="title"
                                                                placeholder="عنوان واضح للمهمة">
                                                        </div>
                                                        @error('title')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">أولوية المهمة</label>
                                                        <select class="form-select" wire:model.defer="priority">
                                                            <option value="low">منخفضة</option>
                                                            <option value="medium">متوسطة</option>
                                                            <option value="high">عالية</option>
                                                        </select>
                                                        @error('priority')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">الوصف</label>
                                                    <textarea class="form-control" rows="3" wire:model.defer="description" placeholder="تفاصيل المهمة..."></textarea>
                                                    @error('description')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">تاريخ البدء</label>
                                                        <input type="date" class="form-control"
                                                            wire:model.defer="start_date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">تاريخ الانتهاء</label>
                                                        <input type="date" class="form-control"
                                                            wire:model.defer="due_date">
                                                        @error('due_date')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">الحالة</label>
                                                        <select class="form-select" wire:model.defer="status">
                                                            <option value="pending">قيد الانتظار</option>
                                                            <option value="in_progress">قيد التنفيذ</option>
                                                            <option value="completed">مكتملة</option>
                                                        </select>
                                                        @error('status')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">نسبة الإنجاز (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                wire:model.defer="progress" min="0"
                                                                max="100">
                                                            <span class="input-group-text"><i
                                                                    class="las la-chart-bar"></i></span>
                                                        </div>
                                                        @error('progress')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="text-end mt-4">
                                                    <button type="submit"
                                                        class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
                                                        <i class="las la-save me-1"></i> حفظ المهمة
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>

                    <h4 class="header-title mb-3 mt-0">
                        <i class="mdi mdi-format-list-bulleted me-2"></i>
                        قائمة المهام الخاصة بالمشروع
                        <span class="badge bg-secondary ms-2">
                            {{ $project->tasks->count() }}
                        </span>
                    </h4>

                    <div>
                        <!-- قائمة المهام -->
                        <div class="row row-cols-2 g-1">
                            @forelse ($project->tasks as $task)
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="task-box">
                                                <div class="task-priority-icon">
                                                    @if ($task->status === 'pending')
                                                        <i class="fas fa-circle text-warning"
                                                            title="قيد الانتظار"></i>
                                                    @elseif($task->status === 'in_progress')
                                                        <i class="fas fa-circle text-info" title="قيد التنفيذ"></i>
                                                    @elseif($task->status === 'completed')
                                                        <i class="fas fa-circle text-success" title="مكتمل"></i>
                                                    @endif
                                                </div>

                                                <p class="text-muted float-end">
                                                    <span class="text-muted">
                                                        <i class="far fa-fw fa-clock"></i>
                                                        {{ $task->created_at->translatedFormat('h:i A') }} ·
                                                        {{ $task->created_at->translatedFormat('d m Y') }}
                                                    </span>
                                                </p>


                                                <h5 class="mt-0">
                                                    {{ $task->title }}
                                                </h5>
                                                <p class="text-muted mb-1">
                                                    {{ $task->description ?: 'لا يوجد وصف لهذه المهمة.' }}
                                                </p>
                                                <p class="text-muted text-end mb-1">
                                                    {{ $task->progress }}% مكتمل
                                                </p>
                                                @php
                                                    $color = 'bg-danger';
                                                    if ($task->progress >= 80) {
                                                        $color = 'bg-success';
                                                    } elseif ($task->progress >= 50) {
                                                        $color = 'bg-info';
                                                    } elseif ($task->progress >= 30) {
                                                        $color = 'bg-warning';
                                                    }
                                                @endphp

                                                <div class="progress mb-4" style="height: 4px;">
                                                    <div class="progress-bar {{ $color }}" role="progressbar"
                                                        style="width: {{ $task->progress }}%;"
                                                        aria-valuenow="{{ $task->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <div class="img-group">
                                                        <a class="user-avatar user-avatar-group"
                                                            href="{{ route('profile', $project->owner->id) }}">
                                                            <img src="{{ $project->owner->avatar_url ?? asset('assets/images/users/default.jpg') }}"
                                                                alt="user" class="rounded-circle thumb-xs">
                                                        </a>
                                                    </div><!--end img-group-->
                                                    <ul class="list-inline mb-0 align-self-center">
                                                        <li class="list-item d-inline-block">
                                                            <a class="btn btn-xs btn-info fw-bold"
                                                                href="{{ route('tasks.edit', $task->id) }}">
                                                                <i class="mdi mdi-pencil-outline font-13"></i>
                                                                <span class="font-13">تعديل</span>
                                                            </a>
                                                        </li>
                                                        <li class="list-item d-inline-block">
                                                            <button wire:click="confirmDelete({{ $task->id }})"
                                                                class="btn btn-danger btn-xs">
                                                                <i class="mdi mdi-delete font-13"></i>
                                                                <span class="font-13">حذف</span>
                                                            </button>
                                                            <!-- المودال يظهر فقط إذا showDeleteConfirmation = true -->
                                                            @if ($showDeleteConfirmation)
                                                                @if ($showDeleteConfirmation)
                                                                    <div id="showDeleteConfirmation"
                                                                        class="modal fade show d-block" tabindex="-1"
                                                                        style="background: rgba(0, 0, 0, 0.6); display: block; opacity: 1;"
                                                                        aria-modal="true" role="dialog">

                                                                        <div
                                                                            class="modal-dialog modal-dialog-centered modal-md">
                                                                            <div
                                                                                class="modal-content rounded-4 border-0 shadow-lg animate__animated animate__fadeInDown">

                                                                                <!-- رأس المودال -->
                                                                                <div
                                                                                    class="modal-header bg-gradient bg-danger text-white rounded-top-4 p-4 border-0 position-relative">
                                                                                    <div
                                                                                        class="position-absolute top-0 start-50 translate-middle-x mt-n5">
                                                                                        <div
                                                                                            class="bg-white rounded-circle p-3 shadow">
                                                                                            <i
                                                                                                class="las la-trash-alt text-danger display-4"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <h4
                                                                                        class="modal-title mx-auto mt-4 fw-bold">
                                                                                        تأكيد الحذف
                                                                                    </h4>
                                                                                    <button type="button"
                                                                                        class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                                                                                        wire:click="$set('showDeleteConfirmation', false)">
                                                                                    </button>
                                                                                </div>

                                                                                <!-- جسم المودال -->
                                                                                <div
                                                                                    class="modal-body text-center py-5 px-4">
                                                                                    <p class="fs-5 text-muted mb-2">هل
                                                                                        أنت متأكد أنك تريد حذف هذه
                                                                                        المهمة؟</p>
                                                                                    <p
                                                                                        class="text-danger fw-bold mb-0">
                                                                                        ⚠️ لا يمكن التراجع عن هذا
                                                                                        الإجراء.</p>
                                                                                </div>

                                                                                <!-- أزرار -->
                                                                                <div
                                                                                    class="modal-footer bg-light rounded-bottom-4 border-0 d-flex justify-content-center gap-3 p-4">
                                                                                    <button
                                                                                        class="btn btn-outline-secondary btn-lg px-4 rounded-pill"
                                                                                        wire:click="$set('showDeleteConfirmation', false)">
                                                                                        إلغاء
                                                                                    </button>
                                                                                    <button
                                                                                        class="btn btn-danger btn-lg px-4 rounded-pill fw-bold d-inline-flex align-items-center"
                                                                                        wire:click="deleteTask({{ $task->id }})"
                                                                                        wire:loading.attr="disabled"
                                                                                        wire:target="deleteTask">

                                                                                        {{-- عند التحميل --}}
                                                                                        <span wire:loading
                                                                                            wire:target="deleteTask">
                                                                                            <span
                                                                                                class="spinner-border spinner-border-sm me-2"
                                                                                                role="status"
                                                                                                aria-hidden="true"></span>
                                                                                            جاري الحذف...
                                                                                        </span>

                                                                                        {{-- عند الحالة العادية --}}
                                                                                        <span wire:loading.remove
                                                                                            wire:target="deleteTask">
                                                                                            <i
                                                                                                class="las la-trash-alt me-2"></i>
                                                                                            حذف نهائي
                                                                                        </span>
                                                                                    </button>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><!--end task-box-->
                                        </div><!--end card-body-->
                                    </div><!--end card-->
                                </div>
                            @empty
                                <div class="card-body">
                                    <p class="card-text">لا توجد مهام لهذا المشروع.</p>
                                </div>
                            @endforelse
                        </div>
                    </div><!--end project-list-right-->
                </div><!--end /div-->
            </div>
        </div>
    </div>
</div>
