<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-3xl font-black text-primary-950">تسجيل الدخول</h1>
        <p class="text-neutral-500 mt-2">أهلاً بك مجدداً، أدخل بيانات حسابك للمتابعة</p>
    </div>

    <x-auth-session-status class="mb-4 bg-green-50 text-green-700 border border-green-200 rounded-xl p-3 text-sm font-medium" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" class="font-bold text-neutral-700 mb-2 block" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email"
                class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                type="email" name="email" :value="old('email')" placeholder="example@vivio.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm font-medium" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" class="font-bold text-neutral-700 mb-2 block" :value="__('كلمة المرور')" />
            <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                            type="password"
                            name="password"
                            required autocomplete="off" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm font-medium" />
        </div>

        <div class="block mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-neutral-300 text-primary-600 shadow-sm focus:ring-primary-500 w-4 h-4" name="remember">
                <span class="mr-2 text-sm font-medium text-neutral-600">{{ __('تذكرني') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-secondary-600 hover:text-secondary-700 transition" href="{{ route('password.request') }}">
                    {{ __('نسيت كلمة المرور؟') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3.5 rounded-xl font-black text-lg bg-gradient-to-l from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 shadow-lg shadow-primary-200/60 transition-all duration-200 hover:shadow-xl hover:shadow-primary-300/60 hover:-translate-y-0.5">
                {{ __('تسجيل الدخول') }}
                <span class="mr-2">→</span>
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="mt-6 pt-5 border-t border-neutral-100 text-center">
                <span class="text-sm text-neutral-500 font-medium">ليس لديك حساب؟</span>
                <a class="mr-1 text-sm font-black text-secondary-600 hover:text-secondary-700 transition" href="{{ route('register') }}">
                    إنشاء حساب جديد
                </a>
            </div>
        @endif
    </form>

</x-guest-layout>
