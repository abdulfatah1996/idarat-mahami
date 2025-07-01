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
                         <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">المشاريع</a></li>

                         <li class="breadcrumb-item active">
                             تعديل مشروع
                         </li>
                     </ol>
                 </div>
                 <h4 class="page-title">
                     تعديل مشروع
                 </h4>
             </div><!--end page-title-box-->
         </div><!--end col-->
     </div>
     <!-- end page title end breadcrumb -->
     <div class="row">
         <div class="col-lg-12">
             <div class="card">
                 <div class="card-body">
                     <h4 class="header-title mb-3">
                         تعديل بيانات المشروع
                     </h4>

                     <form wire:submit.prevent="updateProject" class="p-4 border rounded shadow-sm bg-white">

                         <h5 class="mb-4 border-bottom pb-2">
                             <i class="las la-edit me-1 text-warning"></i>
                             تحديث المشروع
                         </h5>

                         <!-- معلومات أساسية -->
                         <div class="row g-3">
                             <div class="col-md-6">
                                 <label class="form-label">اسم المشروع</label>
                                 <div class="input-group">
                                     <span class="input-group-text"><i class="las la-briefcase"></i></span>
                                     <input type="text" class="form-control" id="name" name="name"
                                         wire:model.defer="name" placeholder="مثال: نظام مهام ذكي">
                                 </div>
                                 @error('name')
                                     <small class="text-danger d-block mt-1">{{ $message }}</small>
                                 @enderror
                             </div>

                             <div class="col-md-6">
                                 <label class="form-label">اسم العميل</label>
                                 <div class="input-group">
                                     <span class="input-group-text"><i class="las la-user-tie"></i></span>
                                     <input type="text" id="client_name" name="client_name" class="form-control"
                                         wire:model.defer="client_name" placeholder="مثال: شركة ABC">
                                 </div>
                                 @error('client_name')
                                     <small class="text-danger d-block mt-1">{{ $message }}</small>
                                 @enderror
                             </div>
                         </div>

                         <!-- وصف -->
                         <div class="mt-3">
                             <label class="form-label">الوصف</label>
                             <textarea id="description" name="description" class="form-control" wire:model.defer="description" rows="3"
                                 placeholder="وصف المشروع..."></textarea>
                             @error('description')
                                 <small class="text-danger">{{ $message }}</small>
                             @enderror
                         </div>

                         <!-- الحالة والأولوية -->
                         <div class="row mt-3 g-3">
                             <div class="col-md-6">
                                 <label class="form-label">الحالة</label>
                                 <select class="form-select" wire:model.defer="status">
                                     <option value="new">جديد</option>
                                     <option value="in_progress">قيد التنفيذ</option>
                                     <option value="completed">مكتمل</option>
                                 </select>
                                 @error('status')
                                     <small class="text-danger">{{ $message }}</small>
                                 @enderror
                             </div>

                             <div class="col-md-6">
                                 <label class="form-label">الأولوية</label>
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

                         <!-- الإنجاز والميزانية -->
                         <div class="row mt-3 g-3">
                             <div class="col-md-6">
                                 <label class="form-label">نسبة الإنجاز (%)</label>
                                 <div class="input-group">
                                     <input type="number" class="form-control" wire:model.defer="progress"
                                         min="0" max="100">
                                     <span class="input-group-text"><i class="las la-chart-line"></i></span>
                                 </div>
                                 @error('progress')
                                     <small class="text-danger">{{ $message }}</small>
                                 @enderror
                             </div>

                             <div class="col-md-6">
                                 <label class="form-label">الميزانية</label>
                                 <div class="input-group">
                                     <span class="input-group-text"><i class="las la-dollar-sign"></i></span>
                                     <input type="number" class="form-control" wire:model.defer="budget" min="0"
                                         step="0.01">
                                 </div>
                                 @error('budget')
                                     <small class="text-danger">{{ $message }}</small>
                                 @enderror
                             </div>
                         </div>

                         <!-- التواريخ -->
                         <div class="row mt-3 g-3">
                             <div class="col-md-6">
                                 <label class="form-label">تاريخ البدء</label>
                                 <input type="date" class="form-control" wire:model.defer="start_date">
                             </div>
                             <div class="col-md-6">
                                 <label class="form-label">تاريخ الانتهاء</label>
                                 <input type="date" class="form-control" wire:model.defer="end_date">
                                 @error('end_date')
                                     <small class="text-danger">{{ $message }}</small>
                                 @enderror
                             </div>
                         </div>

                         <!-- الزر -->
                         <div class="text-end mt-4">
                             <button type="submit" class="btn btn-warning px-4 py-2">
                                 <i class="las la-save me-1"></i> تحديث المشروع
                             </button>
                         </div>

                     </form>
                 </div><!--end card-body-->
             </div><!--end card-->
         </div><!--end col-->
     </div><!--end row-->

 </div><!-- container -->
