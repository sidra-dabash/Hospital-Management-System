<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-3xl font-black text-primary-950">إنشاء حساب جديد</h1>
        <p class="text-neutral-500 mt-2">أهلاً بك في Vivio، سجّل بياناتك للمتابعة</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" class="font-bold text-neutral-700 mb-2 block" :value="__('الاسم الكامل')" />
            <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                          type="text" name="name" :value="old('name')" placeholder="أدخل اسمك الكامل" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm font-medium" />
        </div>

        <div>
            <x-input-label for="email" class="font-bold text-neutral-700 mb-2 block" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                          type="email" name="email" :value="old('email')" placeholder="example@vivio.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm font-medium" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="gender" class="font-bold text-neutral-700 mb-2 block" :value="__('الجنس')" />
                <select id="gender" name="gender" class="select-field" required>
                    <option value="">اختر الجنس</option>
                    <option value="male" @selected(old('gender') === 'male')>ذكر</option>
                    <option value="female" @selected(old('gender') === 'female')>أنثى</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2 text-red-500 text-sm font-medium" />
            </div>
            <div>
                <x-input-label for="birth_date" class="font-bold text-neutral-700 mb-2 block" :value="__('تاريخ الميلاد')" />
                <x-text-input id="birth_date" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                              type="date" name="birth_date" :value="old('birth_date')" max="{{ now()->subDay()->toDateString() }}" required />
                <x-input-error :messages="$errors->get('birth_date')" class="mt-2 text-red-500 text-sm font-medium" />
            </div>
            <div class="sm:col-span-2">
                <x-input-label for="phone" class="font-bold text-neutral-700 mb-2 block" :value="__('رقم الهاتف')" />
                <x-text-input id="phone" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                              type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-500 text-sm font-medium" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" class="font-bold text-neutral-700 mb-2 block" :value="__('كلمة المرور')" />
                <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                              type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm font-medium" />
            </div>

            <div>
                <x-input-label for="password_confirmation" class="font-bold text-neutral-700 mb-2 block" :value="__('تأكيد كلمة المرور')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-xl border border-neutral-200 bg-neutral-50 focus:bg-white focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition"
                              type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm font-medium" />
            </div>
        </div>

        <div class="mt-4">
                <label for="terms" class="block">
                    <div class="flex items-center">
                           <input type="checkbox" name="terms" id="terms" required
                               class="rounded border-neutral-300 text-primary-600 shadow-sm focus:ring-primary-500 w-4 h-4" />
                        <div class="mr-2">
                                أوافق على شروط الاستخدام وسياسة الخصوصية.
                        </div>
                    </div>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-2" />
            </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3.5 rounded-xl font-black text-lg bg-gradient-to-l from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 shadow-lg shadow-primary-200/60 transition-all duration-200 hover:shadow-xl hover:shadow-primary-300/60 hover:-translate-y-0.5">
                {{ __('إنشاء حساب') }}
                <span class="mr-2">→</span>
            </x-primary-button>
        </div>

        <div class="mt-6 pt-5 border-t border-neutral-100 text-center">
            <span class="text-sm text-neutral-500 font-medium">لديك حساب بالفعل؟</span>
            <a class="mr-1 text-sm font-black text-secondary-600 hover:text-secondary-700 transition" href="{{ route('login') }}">
                تسجيل الدخول هنا
            </a>
        </div>
    </form>

    <div class="mt-6 rounded-2xl bg-secondary-50 border border-secondary-100 p-4 text-sm text-neutral-700 font-medium">
        ⚠️ ملاحظة: تسجيل الحسابات هنا يكون كمريض عادي بشكل افتراضي. إذا أردت حساب طبيب أو موظف تواصل مع مدير النظام.
    </div>
</x-guest-layout>
