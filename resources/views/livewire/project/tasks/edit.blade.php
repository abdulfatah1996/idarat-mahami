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

    <!-- العنوان والمسار -->
    <div class="row mb-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item fw-bolder"><a
                                href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('tasks.index') }}">
                                المهام
                            </a>
                        </li>
                        <li class="breadcrumb-item active">تعديل المهمة</li>
                    </ol>
                </div>
                <h4 class="page-title">تعديل المهمة</h4>
            </div>
        </div>
    </div>

    <!-- النموذج -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="updateTask" class="p-4 border rounded shadow-sm bg-white">

                        <h5 class="mb-4 border-bottom pb-2">
                            <i class="las la-tasks me-1 text-info"></i>
                            تعديل المهمة
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">المشروع المرتبط</label>
                                <select class="form-select" wire:model.defer="project_id">
                                    <option value="">-- اختر المشروع --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">عنوان المهمة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-tag"></i></span>
                                    <input type="text" class="form-control" wire:model.defer="title"
                                        placeholder="عنوان واضح للمهمة">
                                </div>
                                @error('title')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">أولوية المهمة</label>
                                <select class="form-select" wire:model.defer="priority">
                                    <option value="low">منخفضة</option>
                                    <option value="medium">متوسطة</option>
                                    <option value="high">عالية</option>
                                </select>
                                @error('priority')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" rows="3" wire:model.defer="description" placeholder="تفاصيل المهمة..."></textarea>
                            @error('description')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row mt-3 g-3">
                            <div class="col-md-6">
                                <label class="form-label">تاريخ البدء</label>
                                <input type="date" class="form-control" wire:model.defer="start_date">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" wire:model.defer="due_date">
                                @error('due_date')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3 g-3">
                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <select class="form-select" wire:model.defer="status">
                                    <option value="pending">قيد الانتظار</option>
                                    <option value="in_progress">قيد التنفيذ</option>
                                    <option value="completed">مكتملة</option>
                                </select>
                                @error('status')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نسبة الإنجاز (%)</label>
                                <div class="input-group">
                                    <input type="number" min="0" max="100" class="form-control"
                                        wire:model.defer="progress">
                                    <span class="input-group-text"><i class="las la-chart-bar"></i></span>
                                </div>
                                @error('progress')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-warning px-4 py-2">
                                <i class="las la-save me-1"></i> تحديث المهمة
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
