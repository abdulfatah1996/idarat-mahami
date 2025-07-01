<!-- Login Card -->
<div class="min-h-screen bg-gradient-to-tr from-sky-50 via-white to-sky-100 flex items-center justify-center px-4">
    <div class="bg-white shadow-xl border border-gray-100 rounded-2xl w-full max-w-sm p-6 space-y-6">
        <!-- إشعار -->
        @if ($showToast)
            <div class="fixed top-5 right-5 px-4 py-3 rounded-lg shadow-lg text-white z-50 flex items-center space-x-2
        {{ $type === 'error' ? 'bg-red-500' : 'bg-green-500' }}"
                wire:poll.3s="hideToast" key="{{ $timer }}">
                {{-- أيقونة --}}
                @if ($type === 'success')
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @elseif ($type === 'error')
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif

                {{-- الرسالة --}}
                <span>{{ $message }}</span>
            </div>
        @endif

        <!-- Logo + Title -->
        <div class="text-center">
            <img src="{{ asset('favicon.svg') }}" class="h-20 mx-auto mb-4" alt="Logo">

            <h1 class="text-2xl font-extrabold text-indigo-700 tracking-tight">
                👋 مرحبًا بك من جديد!
            </h1>

            <p class="text-sm text-gray-600 mt-1">
                سجل دخولك للوصول إلى لوحة التحكم الخاصة بك.
            </p>
        </div>


        <!-- Login Form -->
        <form wire:submit.prevent="login" class="space-y-4">
            <!-- Email -->
            <div>
                <label class="block text-xs text-gray-500 mb-1">البريد الإلكتروني</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="m22 7-9 6-9-6" />
                        <rect x="2" y="4" width="20" height="16" rx="2" />
                    </svg>
                    <input type="email" wire:model="email"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="you@example.com">
                </div>
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs text-gray-500 mb-1">كلمة المرور</label>
                <div class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400 me-2" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M12 17v.01M7 10V7a5 5 0 0110 0v3M5 10h14v10H5z" />
                    </svg>
                    <input type="password" wire:model="password"
                        class="bg-transparent w-full text-sm placeholder:text-gray-400 focus:outline-none"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-xs text-gray-500">
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="remember" class="rounded border-gray-300">
                    <span>تذكرني</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">نسيت كلمة
                    المرور؟</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2 py-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white font-semibold transition text-sm h-10">
                <div wire:loading wire:target="login"
                    class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                <span wire:loading.remove>تسجيل الدخول</span>
            </button>
        </form>

        <!-- Link to register -->
        <p class="text-center text-xs text-gray-500">
            لا تملك حساب؟ <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:underline">سجّل
                الآن</a>
        </p>
    </div>
</div>
