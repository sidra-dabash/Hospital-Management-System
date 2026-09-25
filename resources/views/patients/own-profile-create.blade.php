<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="card p-6 sm:p-8">
            <h1 class="text-2xl font-black text-primary-950">إكمال ملف المريض</h1>
            <p class="mt-2 text-neutral-600">أدخل بياناتك الأساسية مرة واحدة، ثم تابع لحجز موعدك.</p>

            <form method="POST" action="{{ route('patient.profile.store') }}" class="mt-6 space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="gender" class="block text-sm font-bold mb-2">الجنس <span class="text-red-500">*</span></label>
                        <select id="gender" name="gender" class="select-field" required>
                            <option value="">اختر الجنس</option>
                            <option value="male" @selected(old('gender') === 'male')>ذكر</option>
                            <option value="female" @selected(old('gender') === 'female')>أنثى</option>
                        </select>
                        @error('gender')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-bold mb-2">تاريخ الميلاد <span class="text-red-500">*</span></label>
                        <input id="birth_date" type="date" name="birth_date" max="{{ now()->subDay()->toDateString() }}" value="{{ old('birth_date') }}" class="input-field" required>
                        @error('birth_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold mb-2">رقم الهاتف <span class="text-red-500">*</span></label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="input-field" required>
                        @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="blood_type" class="block text-sm font-bold mb-2">فصيلة الدم</label>
                        <select id="blood_type" name="blood_type" class="select-field">
                            <option value="">غير محدد</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                                <option value="{{ $type }}" @selected(old('blood_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-bold mb-2">العنوان</label>
                        <input id="address" name="address" value="{{ old('address') }}" class="input-field">
                    </div>
                    <div>
                        <label for="emergency_contact" class="block text-sm font-bold mb-2">جهة اتصال للطوارئ</label>
                        <input id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" class="input-field">
                    </div>
                </div>
                <button type="submit" class="btn-primary">حفظ ومتابعة حجز الموعد</button>
            </form>
        </div>
    </div>
</x-app-layout>
