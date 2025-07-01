<div class="min-h-screen bg-gradient-to-tr from-sky-50 via-white to-sky-100 flex items-center justify-center px-4">
    <div class="bg-white shadow-xl border border-gray-100 rounded-2xl w-full max-w-sm p-6 space-y-6">

        {{-- إشعار --}}
        @if ($showToast)
            <div class="fixed top-5 right-5 px-4 py-3 rounded-lg shadow-lg text-white z-50 flex items-center gap-2
                {{ $type === 'error' ? 'bg-red-500' : 'bg-green-500' }}"
                wire:poll.3s="hideToast" key="{{ $timer }}">
                @if ($type === 'success')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif
                <span class="text-sm font-medium">{{ $message }}</span>
            </div>
        @endif

        {{-- عنوان --}}
        <div class="text-center">
            <img src="{{ asset('favicon.svg') }}" class="h-10 mx-auto mb-4" alt="Logo">
            <h1 class="text-2xl font-extrabold text-indigo-700 tracking-tight">📝 إنشاء حساب جديد</h1>
            <p class="text-sm text-gray-600">املأ البيانات للانضمام إلى المنصة</p>
        </div>

        {{-- نموذج التسجيل --}}
        <form wire:submit.prevent="register" class="space-y-4">

            {{-- الاسم --}}
            <div>
                <label class="block text-xs text-gray-500 mb-1">الاسم الكامل</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M5 20h14M12 14a5 5 0 100-10 5 5 0 000 10z" />
                    </svg>
                    <input wire:model.lazy="name" type="text"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="الاسم الكامل">
                </div>
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- البريد --}}
            <div>
                <label class="block text-xs text-gray-500 mb-1">البريد الإلكتروني</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="m22 7-9 6-9-6" />
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                    </svg>
                    <input wire:model.lazy="email" type="email"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="you@example.com">
                </div>
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- كلمة المرور --}}
            <div>
                <label class="block text-xs text-gray-500 mb-1">كلمة المرور</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M12 17v.01M7 10V7a5 5 0 0110 0v3M5 10h14v10H5z" />
                    </svg>
                    <input wire:model.lazy="password" type="password"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div>
                <label class="block text-xs text-gray-500 mb-1">تأكيد كلمة المرور</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M12 17v.01M7 10V7a5 5 0 0110 0v3M5 10h14v10H5z" />
                    </svg>
                    <input wire:model.lazy="password_confirmation" type="password"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="••••••••">
                </div>
                @error('password_confirmation')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- زر التسجيل --}}
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2 py-2 rounded-md bg-indigo-500 hover:bg-indigo-600 text-white font-semibold transition text-sm h-10">
                <div wire:loading wire:target="register"
                    class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                <span wire:loading.remove>إنشاء الحساب</span>
            </button>
        </form>

        {{-- رابط تسجيل الدخول --}}
        <p class="text-center text-xs text-gray-500">
            لديك حساب؟ <a href="{{ route('login') }}" class="text-indigo-500 font-semibold hover:underline">سجّل
                الدخول</a>
        </p>
    </div>
</div>
