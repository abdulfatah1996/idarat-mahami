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
                             المهام المنشأة
                         </li>
                     </ol>
                 </div>
                 <h4 class="page-title">
                     المهام المنشأة
                 </h4>
             </div><!--end page-title-box-->
         </div><!--end col-->
     </div>
     <!-- end page title end breadcrumb -->
     <div class="row">
         <div class="col-lg-12">
             <div class="card">
                 <div class="card-header py-3">
                     <h4 class="fw-bolder">عرض المهام</h4>
                     <p class="text-muted mb-0">
                         هنا يمكنك عرض جميع المهام التي قمت بإنشائها.
                     </p>
                 </div>
                 <div class="card-body relative">
                     @forelse ($projects as $project)
                         <div class="project-item">
                             <h5>{{ $project->name }}</h5>
                             <p>{{ $project->description }}</p>
                         </div>
                         @forelse ($project->tasks as $task)
                             <div class="col">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="task-box">
                                             <div class="task-priority-icon">
                                                 @if ($task->status === 'pending')
                                                     <i class="fas fa-circle text-warning" title="قيد الانتظار"></i>
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
                                                                                 <p class="text-danger fw-bold mb-0">
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
                             <div class="card-body text-center p-2 border">
                                 <h6 class="text-muted">
                                     <i class="las la-exclamation-triangle text-warning me-2"></i>
                                     لا توجد مهام لهذا المشروع.
                                 </h6>
                             </div>
                         @endforelse
                     @empty
                         <p>لا توجد مهام متاحة للعرض.</p>
                     @endforelse
                 </div>
             </div>
         </div>
     </div>
 </div>
