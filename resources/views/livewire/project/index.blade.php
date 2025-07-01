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
     <!-- Page-Title -->
     <div class="row">
         <div class="col-sm-12">
             <div class="page-title-box">
                 <div class="float-end">
                     <ol class="breadcrumb">
                         <li class="breadcrumb-item fw-bolder">
                             <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
                         </li><!--end nav-item-->
                         <li class="breadcrumb-item active">
                             المشاريع المنشأة
                         </li>
                     </ol>
                 </div>
                 <h4 class="page-title">
                     المشاريع المنشأة
                 </h4>
             </div><!--end page-title-box-->
         </div><!--end col-->
     </div>
     <!-- end page title end breadcrumb -->
     <div class="row mb-4">
         <livewire:project.chart.budget-chart />
     </div>

     <div class="row">
         <div class="col-lg-12">
             <div class="card">
                 <div class="card-header py-3">
                     <h4 class="fw-bolder">عرض المشاريع</h4>
                     <p class="text-muted mb-0">
                         هنا يمكنك عرض جميع المشاريع التي قمت بإنشائها.
                     </p>
                 </div>
                 <div class="card-body relative">
                     <div class="row mb-4">
                         <div class="col-12">
                             <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                                 <!-- أدوات البحث والفلاتر -->
                                 <div class="d-flex flex-wrap gap-3">
                                     <!-- مربع البحث -->
                                     <div class="flex-grow-1" style="min-width: 200px;">
                                         <input type="search" wire:model.live="search"
                                             class="form-control rounded-pill" placeholder="ابحث عن مشروع..." />
                                     </div>

                                     <!-- فلتر الحالة -->
                                     <div>
                                         <select class="form-select" wire:model.live="filterStatus">
                                             <option value="">كل الحالات</option>
                                             <option value="new">جديد</option>
                                             <option value="in_progress">قيد التنفيذ</option>
                                             <option value="completed">مكتمل</option>
                                         </select>
                                     </div>

                                     <!-- فلتر الأولوية -->
                                     <div>
                                         <select class="form-select" wire:model.live="filterPriority">
                                             <option value="">كل الأولويات</option>
                                             <option value="low">منخفضة</option>
                                             <option value="medium">متوسطة</option>
                                             <option value="high">عالية</option>
                                         </select>
                                     </div>
                                 </div>

                                 <!-- أزرار التحكم -->
                                 <div>
                                     <!-- زر حذف المشاريع المحددة -->
                                     <!-- زر حذف مع تأكيد وتحميل -->
                                     <!-- زر فتح المودال -->
                                     <!-- زر فتح المودال مع لودر -->
                                     <button type="button" wire:click="confirmDelete"
                                         class="btn btn-sm btn-danger fw-bolder" wire:loading.attr="disabled"
                                         @if (count($selectedProjects) === 0) disabled @endif>

                                         <!-- يظهر عند عدم التحميل -->
                                         <span wire:loading.remove wire:target="confirmDelete">
                                             <i class="las la-trash-alt"></i> حذف المحدد
                                         </span>

                                         <!-- يظهر أثناء التحميل -->
                                         <span wire:loading wire:target="confirmDelete">
                                             <i class="fas fa-spinner fa-spin"></i> جاري التحقق...
                                         </span>
                                     </button>


                                     <!-- مودال تأكيد الحذف -->
                                     @if ($showDeleteModal)
                                         <div class="modal fade show d-block" tabindex="-1" role="dialog"
                                             style="background: rgba(0, 0, 0, 0.6); z-index:1055;">
                                             <div class="modal-dialog modal-dialog-centered" role="document">
                                                 <div
                                                     class="modal-content border-0 rounded-5 shadow-lg overflow-hidden">

                                                     <!-- Header -->
                                                     <div class="modal-header bg-gradient bg-danger text-white py-4">
                                                         <h4 class="modal-title fw-bold mb-0 d-flex align-items-center">
                                                             <i class="las la-exclamation-circle fs-2 me-2"></i>
                                                             تأكيد الحذف النهائي
                                                         </h4>
                                                     </div>

                                                     <!-- Body -->
                                                     <div class="modal-body text-center py-5">
                                                         <p class="fs-5 text-muted mb-3">
                                                             هل أنت متأكد أنك تريد حذف المشاريع المحددة؟
                                                         </p>
                                                         <p class="text-danger fw-semibold fs-6">
                                                             ⚠️ هذا الإجراء لا يمكن التراجع عنه!
                                                         </p>
                                                     </div>

                                                     <!-- Footer -->
                                                     <div class="modal-footer justify-content-center bg-light py-4">
                                                         <button type="button"
                                                             wire:click="$set('showDeleteModal', false)"
                                                             class="btn btn-light border px-4 py-2 rounded-pill fw-semibold">
                                                             <i class="las la-times-circle me-1"></i> تراجع
                                                         </button>

                                                         <button type="button" wire:click="deleteSelected"
                                                             wire:loading.attr="disabled"
                                                             class="btn btn-danger px-4 py-2 rounded-pill fw-semibold position-relative">

                                                             <!-- زر عادي -->
                                                             <span wire:loading.remove wire:target="deleteSelected">
                                                                 <i class="las la-trash-alt me-1"></i> نعم، احذف الآن
                                                             </span>

                                                             <!-- أثناء التحميل -->
                                                             <span wire:loading wire:target="deleteSelected">
                                                                 <span class="spinner-border spinner-border-sm me-2"
                                                                     role="status"></span>
                                                                 جاري الحذف...
                                                             </span>
                                                         </button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @endif
                                     <!-- زر تصديد أكسل -->
                                     <button type="button" wire:click="exportExcel"
                                         class="btn btn-sm btn-primary fw-bolder">
                                         تصدير إلى Excel
                                     </button>
                                 </div>

                             </div>
                         </div>
                     </div>



                     <div class="table-responsive">
                         <table class="table mb-0">
                             <thead>
                                 <tr>
                                     <th>
                                         <input type="checkbox" wire:model.live="selectAll" class="form-check-input" />
                                     </th>
                                     <th wire:click="sortBy('number')" class="fw-bolder text-secondary"
                                         style="cursor:pointer">
                                         #
                                         @if ($sortColumn === 'number')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th wire:click="sortBy('name')" style="cursor:pointer"
                                         class="fw-bolder text-secondary">
                                         المشروع
                                         @if ($sortColumn === 'name')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         المالك
                                         @if ($sortColumn === 'owner')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         الموازنة
                                         @if ($sortColumn === 'budget')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         الحالة
                                         @if ($sortColumn === 'status')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         الأولوية
                                         @if ($sortColumn === 'priority')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         البداية
                                         @if ($sortColumn === 'created_at')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary">
                                         النهاية
                                         @if ($sortColumn === 'end_date')
                                             <i class="ti {{ $sortDirection ? 'ti-arrow-up' : 'ti-arrow-down' }}"></i>
                                         @endif
                                     </th>
                                     <th class="fw-bolder text-secondary text-center">
                                         الإجراءات
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @forelse ($projects as $project)
                                     <tr wire:key="{{ $project->id }}">
                                         {{-- خانة التحديد --}}
                                         <td>
                                             <input type="checkbox" wire:model.live="selectedProjects"
                                                 value="{{ $project->id }}" class="form-check-input" />
                                         </td>
                                         {{-- رقم المشروع --}}
                                         <td class="text-secondary">
                                             {{ $project->number }}
                                         </td>
                                         <td style="min-width: 200px;">
                                             {{-- اسم المشروع كرابط --}}
                                             <a href="#"
                                                 class="text-decoration-none text-dark fw-semibold d-block mb-1">
                                                 {{ $project->name }}
                                             </a>

                                             {{-- شريط التقدّم --}}
                                             <div class="progress" style="height: 6px;">
                                                 <div class="progress-bar @if ($project->progress < 40) bg-danger @elseif ($project->progress < 75)     bg-warning @else     bg-success @endif progress-bar-striped progress-bar-animated"
                                                     role="progressbar" style="width: {{ $project->progress }}%;"
                                                     aria-valuenow="{{ $project->progress }}" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                 </div>
                                             </div>
                                         </td>

                                         <td>
                                             <div class="d-flex align-items-center gap-2">
                                                 {{-- صورة المستخدم --}}
                                                 <img src="{{ $project->owner->avatar_url ?? asset('assets/images/users/default.jpg') }}"
                                                     alt="صورة {{ $project->owner->name }}" class="rounded-circle"
                                                     style="width: 40px; height: 40px; object-fit: cover; box-shadow: 0 0 3px rgba(0,0,0,0.2);">

                                                 {{-- الاسم والبريد --}}
                                                 <div class="d-flex flex-column">
                                                     <span
                                                         class="fw-semibold text-dark">{{ $project->owner->name }}</span>
                                                     <small class="text-muted">{{ $project->owner->email }}</small>
                                                 </div>
                                             </div>
                                         </td>

                                         <td>
                                             {{ number_format($project->budget, 2) }} $
                                         </td>
                                         <td>
                                             @php
                                                 $statusClasses = [
                                                     'new' => 'badge-soft-primary',
                                                     'in_progress' => 'badge-soft-warning',
                                                     'completed' => 'badge-soft-success',
                                                 ];

                                                 $statusLabels = [
                                                     'new' => 'جديد',
                                                     'in_progress' => 'قيد التنفيذ',
                                                     'completed' => 'مكتمل',
                                                 ];

                                                 $statusIcons = [
                                                     'new' => 'ti-plus', // أيقونة جديد
                                                     'in_progress' => 'ti-loader', // أيقونة تحميل/قيد التنفيذ
                                                     'completed' => 'ti-check', // أيقونة مكتمل
                                                 ];

                                                 $status = $project->status;
                                             @endphp

                                             <span
                                                 class="badge d-inline-flex align-items-center gap-1 {{ $statusClasses[$status] ?? 'badge-soft-secondary' }}">
                                                 <i class="ti {{ $statusIcons[$status] ?? 'ti-info-circle' }}"></i>
                                                 {{ $statusLabels[$status] ?? $status }}
                                             </span>
                                         </td>

                                         <td>
                                             @php
                                                 $priorityClasses = [
                                                     'low' => 'badge-soft-success',
                                                     'medium' => 'badge-soft-warning',
                                                     'high' => 'badge-soft-danger',
                                                 ];

                                                 $priorityLabels = [
                                                     'low' => 'منخفضة',
                                                     'medium' => 'متوسطة',
                                                     'high' => 'عالية',
                                                 ];

                                                 $priorityIcons = [
                                                     'low' => 'ti-arrow-down',
                                                     'medium' => 'ti-arrows-down-up',
                                                     'high' => 'ti-arrow-up',
                                                 ];

                                                 $priority = $project->priority;
                                             @endphp

                                             <span
                                                 class="badge d-inline-flex align-items-center gap-1 {{ $priorityClasses[$priority] ?? 'badge-soft-secondary' }}">
                                                 <i
                                                     class="ti {{ $priorityIcons[$priority] ?? 'ti-alert-circle' }}"></i>
                                                 {{ $priorityLabels[$priority] ?? $priority }}
                                             </span>
                                         </td>

                                         <td>
                                             {{ $project->start_date ? $project->start_date->diffForHumans() : 'غير محدد' }}

                                         </td>
                                         <td>
                                             {{ $project->end_date ? $project->end_date->diffForHumans() : 'غير محدد' }}
                                         </td>
                                         <td class="text-center">
                                             <div class="dropdown">
                                                 <!-- زر القائمة -->
                                                 <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                                     id="actionDropdown{{ $project->id }}" data-bs-toggle="dropdown"
                                                     aria-expanded="false">
                                                     <i class="las la-ellipsis-h"></i>
                                                 </button>

                                                 <!-- القائمة -->
                                                 <ul class="dropdown-menu"
                                                     aria-labelledby="actionDropdown{{ $project->id }}">
                                                     <!-- عرض التفاصيل -->
                                                     <li>
                                                         <a class="dropdown-item d-flex align-items-center"
                                                             href="{{ route('projects.show', $project->id) }}">
                                                             <i class="las la-eye text-primary me-2"></i>
                                                             عرض التفاصيل
                                                         </a>
                                                     </li>

                                                     <!-- تعديل -->
                                                     <li>
                                                         <a class="dropdown-item d-flex align-items-center"
                                                             href="{{ route('projects.edit', $project->id) }}">
                                                             <i class="las la-pen text-warning me-2"></i>
                                                             تعديل المشروع
                                                         </a>
                                                     </li>

                                                     <!-- زر الحذف -->
                                                     <li>
                                                         <button
                                                             class="dropdown-item d-flex align-items-center text-danger"
                                                             data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                             wire:click="$set('selectedId', {{ $project->id }})">
                                                             <i class="las la-trash-alt me-2"></i>
                                                             حذف المشروع
                                                         </button>

                                                     </li>
                                                 </ul>
                                             </div>

                                             <!-- مودال تأكيد الحذف -->
                                             <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1"
                                                 aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered modal-md">
                                                     <div class="modal-content border-0 shadow-lg rounded-4">

                                                         <!-- Header -->
                                                         <div class="modal-header bg-danger text-white rounded-top-4">
                                                             <div class="d-flex align-items-center gap-2">
                                                                 <i class="las la-exclamation-triangle fs-2"></i>
                                                                 <h5 class="modal-title fw-bold"
                                                                     id="deleteModalLabel">تأكيد الحذف</h5>
                                                             </div>
                                                             <button type="button" class="btn-close btn-close-white"
                                                                 data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                         </div>

                                                         <!-- Body -->
                                                         <div class="modal-body text-center py-4">
                                                             <p class="mb-3 fs-5 text-danger fw-semibold">
                                                                 هل أنت متأكد أنك تريد حذف هذا المشروع؟
                                                             </p>
                                                             <p class="text-muted small">هذا الإجراء لا يمكن التراجع
                                                                 عنه بعد الحذف.</p>
                                                         </div>

                                                         <!-- Footer -->
                                                         <div
                                                             class="modal-footer border-0 d-flex justify-content-between px-4 pb-4">
                                                             <button type="button"
                                                                 class="btn btn-outline-secondary px-4"
                                                                 data-bs-dismiss="modal">
                                                                 إلغاء
                                                             </button>
                                                             <button type="button" class="btn btn-danger px-4"
                                                                 wire:click="deleteProject">
                                                                 <i class="las la-trash-alt me-1"></i> حذف الآن
                                                             </button>
                                                         </div>

                                                     </div>
                                                 </div>
                                             </div>

                                         </td>

                                     </tr>
                                 @empty
                                     <tr>
                                         <td colspan="8" class="text-center text-muted">
                                             لا توجد مشاريع حالياً.
                                         </td>
                                     </tr>
                                 @endforelse
                         </table>
                     </div>
                     <div class="pagination-sm mt-3">
                         {{ $projects->links() }}

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
