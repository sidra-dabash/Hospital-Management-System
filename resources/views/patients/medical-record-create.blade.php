<x-app-layout>
    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <a href="{{ route('patients.show', $patient) }}" class="text-primary-600 font-bold text-sm hover:text-secondary-700">← العودة إلى ملف المريض</a>
            <h1 class="text-2xl sm:text-3xl font-black text-primary-950 mt-3">إضافة سجل طبي</h1>
            <p class="text-neutral-500 mt-1">تسجيل زيارة وتشخيص وعلاج جديد للمريض {{ $patient->full_name }}.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @include('partials.flash')
        @if($errors->any())
            <div class="mb-5 rounded-xl bg-red-50 border border-red-100 px-5 py-4 text-red-700">
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('patients.medical-records.store', $patient) }}" class="card p-5 sm:p-7 space-y-6">
            @csrf
            <div class="flex items-center gap-3 pb-4 border-b border-neutral-100">
                <div class="w-11 h-11 rounded-xl bg-secondary-100 text-secondary-700 flex items-center justify-center font-black">
                    {{ mb_substr($patient->first_name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-black text-primary-950">{{ $patient->full_name }}</h2>
                    <p class="text-sm text-neutral-500">رقم الملف #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="doctor_id" class="block text-sm font-bold text-primary-900 mb-2">الطبيب <span class="text-red-500">*</span></label>
                    <select id="doctor_id" name="doctor_id" class="select-field" required>
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                د. {{ $doctor->user?->name ?? 'طبيب #' . $doctor->id }}{{ $doctor->specialization ? ' - ' . $doctor->specialization : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="visit_date" class="block text-sm font-bold text-primary-900 mb-2">تاريخ الزيارة <span class="text-red-500">*</span></label>
                    <input id="visit_date" name="visit_date" type="datetime-local" value="{{ old('visit_date', now()->format('Y-m-d\\TH:i')) }}" class="input-field" required>
                </div>
            </div>

            <div>
                <label for="diagnosis" class="block text-sm font-bold text-primary-900 mb-2">التشخيص <span class="text-red-500">*</span></label>
                <textarea id="diagnosis" name="diagnosis" rows="3" class="input-field" placeholder="اكتب التشخيص الطبي بالتفصيل" required>{{ old('diagnosis') }}</textarea>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div>
                    <label for="tests" class="block text-sm font-bold text-primary-900 mb-2">الفحوصات</label>
                    <textarea id="tests" name="tests" rows="4" class="input-field" placeholder="الفحوصات المطلوبة أو نتائجها">{{ old('tests') }}</textarea>
                </div>
                <div>
                    <label for="treatment" class="block text-sm font-bold text-primary-900 mb-2">العلاج</label>
                    <textarea id="treatment" name="treatment" rows="4" class="input-field" placeholder="الخطة العلاجية والتعليمات">{{ old('treatment') }}</textarea>
                </div>
                <div>
                    <label for="prescription" class="block text-sm font-bold text-primary-900 mb-2">الأدوية والوصفة</label>
                    <textarea id="prescription" name="prescription" rows="4" class="input-field" placeholder="اسم الدواء والجرعة وطريقة الاستخدام">{{ old('prescription') }}</textarea>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-bold text-primary-900 mb-2">الملاحظات</label>
                    <textarea id="notes" name="notes" rows="4" class="input-field" placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2 border-t border-neutral-100">
                <a href="{{ route('patients.show', $patient) }}" class="btn-secondary">إلغاء</a>
                <button type="submit" class="btn-blue">حفظ السجل الطبي</button>
            </div>
        </form>
    </div>
</x-app-layout>
