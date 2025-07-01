<div class="">
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
                            </li>
                            <li class="breadcrumb-item active">
                                الملف الشخصي
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">الملف الشخصي</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="met-profile">
                            <div class="row">
                                <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                    <div class="met-profile-main">
                                        <div class="met-profile-main-pic position-relative">
                                            <label for="avatar" class="position-relative" style="cursor: pointer;">
                                                @if ($avatar)
                                                    <img src="{{ $user->avatar_url ?? asset('assets/images/users/default.jpg') }}"
                                                        class="rounded-circle" style="width: 110px; height: 110px;">
                                                @else
                                                    <img src="{{ $user->avatar_url }}" class="rounded-circle"
                                                        style="width: 110px; height: 110px;">
                                                @endif
                                                <i
                                                    class="fas fa-camera position-absolute bottom-0 end-0 bg-dark text-white p-2 rounded-circle"></i>
                                            </label>

                                            <!-- ملف الصورة -->
                                            <input type="file" id="avatar" class="d-none" wire:model="avatar"
                                                accept="image/*">
                                        </div>

                                        @error('avatar')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror


                                        <div class="met-profile_user-detail">
                                            <h5 class="met-user-name">{{ $name }}</h5>
                                            <p class="mb-0 met-user-name-post">{{ $role_label }}</p>
                                            <p class="mb-0 met-user-name-post">
                                                {{ $country ?? 'غير محدد' }} - {{ $city ?? 'غير محدد' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8 me-auto align-self-center">
                                    <ul class="list-unstyled personal-detail mb-0">
                                        <li><i class="las la-phone mr-2 text-secondary font-22 align-middle"></i>
                                            <b>رقم الهاتف </b> : {{ $phone }}
                                        </li>
                                        <li class="mt-2"><i
                                                class="las la-envelope text-secondary font-22 align-middle mr-2"></i>
                                            <b>البريد الإلكتروني </b> : {{ $email }}
                                        </li>
                                        <li class="mt-2"><i
                                                class="las la-globe text-secondary font-22 align-middle mr-2"></i>
                                            <b>العنوان </b> : {{ $address ?? 'غير محدد' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="card-title">تعديل الملف الشخصي</h2>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <div class="row">
                                @foreach ([['الاسم الكامل', 'name'], ['اسم المستخدم', 'username'], ['البريد الإلكتروني', 'email'], ['رقم الهاتف', 'phone'], ['الدولة', 'country'], ['المدينة', 'city'], ['العنوان', 'address']] as [$label, $field])
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $label }}</label>
                                        <input type="text" class="form-control"
                                            wire:model.defer="{{ $field }}">
                                        @error($field)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">السيرة الذاتية</label>
                                    <textarea class="form-control" rows="4" wire:model.defer="bio"></textarea>
                                    @error('bio')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">تغيير كلمة المرور</h2>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="updatePassword">
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور الحالية</label>
                                <input type="password" class="form-control" wire:model.defer="current_password"
                                    autocomplete="current-password">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" wire:model.defer="new_password"
                                    autocomplete="new-password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" class="form-control" wire:model.defer="new_password_confirmation"
                                    autocomplete="new-password">
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-warning">تغيير كلمة المرور</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
