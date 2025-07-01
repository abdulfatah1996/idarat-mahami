 <div class="container-fluid">
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
                             عرض الصفحة الرئيسية
                         </li>
                     </ol>
                 </div>
                 <h4 class="page-title">
                     لوحة التحكم الرئيسية
                 </h4>
             </div><!--end page-title-box-->
         </div><!--end col-->
     </div>
     <!-- end page title end breadcrumb -->
     <div class="container-fluid">
         <div class="row">
             <div class="col-6">
                 <livewire:project.chart.priority-chart />
             </div>
             <div class="col-6">
                 <livewire:project.chart.status-chart />
             </div>
             <div class="col-12">
                 {{-- 🔷 إحصائيات المشاريع --}}
                 <div class="row">
                     <h3 class="mb-3 fw-bold">
                         <i class="mdi mdi-chart-bar me-2"></i>
                         إحصائيات المشاريع
                     </h3>

                     {{-- إجمالي المشاريع --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">إجمالي المشاريع</p>
                                         <h4 class="my-1">{{ $projectsTotal }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-folder"></i> عدد كل المشاريع
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-folder text-muted fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- المشاريع المكتملة --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">المشاريع المكتملة</p>
                                         <h4 class="my-1">{{ $projectsCompleted }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-check-bold text-success"></i> مكتملة بنجاح
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-check-bold text-success fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- المشاريع قيد التنفيذ --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">قيد التنفيذ</p>
                                         <h4 class="my-1">{{ $projectsInProgress }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-timer-sand text-warning"></i> لا تزال جارية
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-timer-sand text-warning fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 {{-- 🔷 إحصائيات المهام --}}
                 <div class="row mt-2">
                     <h3 class="mb-3 fw-bold">
                         <i class="mdi mdi-chart-box-outline me-2"></i>
                         إحصائيات المهام
                     </h3>

                     {{-- إجمالي المهام --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">إجمالي المهام</p>
                                         <h4 class="my-1">{{ $tasksTotal }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-file-document-outline"></i> كل المهام المسجلة
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-file-document-outline text-muted fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- المهام المكتملة --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">المهام المكتملة</p>
                                         <h4 class="my-1">{{ $tasksCompleted }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-check-decagram text-success"></i> تم تنفيذها بنجاح
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-check-decagram text-success fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     {{-- المهام قيد التنفيذ --}}
                     <div class="col-md-6 col-lg-4">
                         <div class="card report-card">
                             <div class="card-body">
                                 <div class="row d-flex justify-content-center">
                                     <div class="col">
                                         <p class="text-dark mb-1 fw-semibold">قيد التنفيذ</p>
                                         <h4 class="my-1">{{ $tasksInProgress }}</h4>
                                         <p class="mb-0 text-truncate text-muted">
                                             <i class="mdi mdi-progress-clock text-warning"></i> المهام الجارية
                                         </p>
                                     </div>
                                     <div class="col-auto align-self-center">
                                         <div
                                             class="bg-light-alt d-flex justify-content-center align-items-center thumb-md rounded-circle">
                                             <i class="mdi mdi-progress-clock text-warning fs-4"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row mt-5">
                 <div class="col-6">
                     {{-- عرض أحدث المشاريع --}}
                     <div class="card shadow-sm border-0">
                         <div class="card-header bg-white">
                             <h3 class="fw-bold text-secondary">
                                 <i class="mdi mdi-folder-multiple me-2"></i>
                                 أحدث المشاريع
                             </h3>
                         </div>

                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-hover mb-0">
                                     <thead>
                                         <tr>
                                             <th>الاسم</th>
                                             <th>الحالة</th>
                                             <th>الأولوية</th>
                                             <th>تاريخ البدء</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @forelse ($latestProjects as $project)
                                             <tr>
                                                 <td>
                                                     <div class="fw-bold">{{ $project->name }}</div>

                                                     @php
                                                         $progress = $project->progress;
                                                         $progressColor =
                                                             $progress < 40
                                                                 ? 'danger'
                                                                 : ($progress < 70
                                                                     ? 'warning'
                                                                     : 'success');
                                                     @endphp

                                                     <div class="mt-1">
                                                         <div class="progress" style="height: 6px;">
                                                             <div class="progress-bar bg-{{ $progressColor }}"
                                                                 role="progressbar"
                                                                 style="width: {{ $progress }}%;"
                                                                 aria-valuenow="{{ $progress }}"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                         </div>
                                                     </div>
                                                 </td>


                                                 <td>
                                                     @php
                                                         $statusText = match ($project->status) {
                                                             'new' => 'جديد',
                                                             'in_progress' => 'قيد التنفيذ',
                                                             'completed' => 'مكتمل',
                                                             default => 'غير معروف',
                                                         };

                                                         $statusColor = match ($project->status) {
                                                             'new' => 'secondary',
                                                             'in_progress' => 'warning',
                                                             'completed' => 'success',
                                                             default => 'light',
                                                         };
                                                     @endphp
                                                     <span
                                                         class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                                                 </td>
                                                 <td>
                                                     @php
                                                         $priorityColor = match ($project->priority) {
                                                             'high' => 'danger',
                                                             'medium' => 'info',
                                                             'low' => 'secondary',
                                                             default => 'light',
                                                         };

                                                         $priorityText = match ($project->priority) {
                                                             'high' => 'عالية',
                                                             'medium' => 'متوسطة',
                                                             'low' => 'منخفضة',
                                                             default => 'غير معروفة',
                                                         };
                                                     @endphp
                                                     <span
                                                         class="badge bg-{{ $priorityColor }}">{{ $priorityText }}</span>
                                                 </td>

                                                 <td>{{ $project->start_date->diffForHumans() }}</td>
                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="5" class="text-center text-muted">لا توجد مشاريع حتى
                                                     الآن.</td>
                                             </tr>
                                         @endforelse
                                     </tbody>
                                 </table>
                             </div>

                             {{-- زر عرض الكل --}}
                             <div class="card-footer text-end bg-white">
                                 <a href="{{ route('projects.index') }}"
                                     class="btn btn-primary btn-sm rounded-pill fw-bold">
                                     عرض جميع المشاريع <i class="mdi mdi-arrow-left ms-1"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-6">
                     {{-- عرض أقرب 3 مهام على وشك الانتهاء --}}
                     <div class="card shadow-sm border-0">
                         <div class="card-header bg-white">
                             <h3 class="fw-bold text-secondary">
                                 <i class="mdi mdi-calendar-clock me-2"></i>
                                 أقرب 5 مهام على وشك الانتهاء
                             </h3>
                         </div>

                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-hover mb-0">
                                     <thead>
                                         <tr>
                                             <th>المهمة</th>
                                             <th>المشروع</th>
                                             <th>الحالة</th>
                                             <th>تاريخ الانتهاء</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @forelse ($upcomingTasks as $task)
                                             <tr>
                                                 <td>
                                                     <div class="fw-bold">{{ $task->title }}</div>

                                                     @php
                                                         $progress = $task->progress;
                                                         $progressColor =
                                                             $progress < 40
                                                                 ? 'danger'
                                                                 : ($progress < 70
                                                                     ? 'warning'
                                                                     : 'success');
                                                     @endphp

                                                     <div class="mt-1">
                                                         <div class="progress" style="height: 6px;">
                                                             <div class="progress-bar bg-{{ $progressColor }}"
                                                                 role="progressbar"
                                                                 style="width: {{ $progress }}%;"
                                                                 aria-valuenow="{{ $progress }}"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                         </div>
                                                     </div>
                                                 </td>

                                                 <td class="text-muted">{{ $task->project->name ?? '—' }}</td>

                                                 <td>
                                                     @php
                                                         $statusText = match ($task->status) {
                                                             'pending' => 'لم تبدأ',
                                                             'in_progress' => 'قيد التنفيذ',
                                                             'completed' => 'مكتملة',
                                                             default => 'غير معروف',
                                                         };

                                                         $statusColor = match ($task->status) {
                                                             'pending' => 'secondary',
                                                             'in_progress' => 'warning',
                                                             'completed' => 'success',
                                                             default => 'light',
                                                         };
                                                     @endphp
                                                     <span
                                                         class="badge bg-{{ $statusColor }}">{{ $statusText }}</span>
                                                 </td>

                                                 <td>{{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}</td>
                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="4" class="text-center text-muted">لا توجد مهام قريبة.
                                                 </td>
                                             </tr>
                                         @endforelse
                                     </tbody>
                                 </table>
                             </div>

                             {{-- زر عرض الكل --}}
                             <div class="card-footer text-end bg-white">
                                 <a href="{{ route('tasks.index') }}"
                                     class="btn btn-primary btn-sm rounded-pill fw-bold">
                                     عرض جميع المهام <i class="mdi mdi-arrow-left ms-1"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div><!-- container -->
