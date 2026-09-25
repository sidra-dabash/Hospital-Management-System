<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('patients.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى قائمة المرضى</a>
                <h1 class="text-3xl font-black text-primary-950 mt-4">الملف الصحي للمريض</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                @if(auth()->user()->hasAnyRole(['admin', 'doctor']))
                    <a href="{{ route('patients.medical-records.create', $patient) }}" class="btn-primary">+ إضافة سجل طبي</a>
                @endif
                @if(auth()->user()->hasAnyRole(['admin', 'accountant']))
                    <a href="{{ route('bills.create', ['patient_id' => $patient->id]) }}" class="btn-secondary">+ إنشاء فاتورة</a>
                @endif
                @unless(auth()->user()->hasRole('receptionist'))
                    <a href="{{ route('patients.record', $patient) }}" class="btn-blue">📄 السجل الطبي (React)</a>
                @endunless
                @if(auth()->user()->hasAnyRole(['admin', 'doctor', 'receptionist']))<a href="{{ route('patients.edit', $patient) }}" class="btn-blue">تعديل البيانات</a>@endif
            </div>
        </div>
        <div class="grid lg:grid-cols-[1fr_280px] gap-6">
            <section class="card p-6">
                <div class="flex items-center gap-4 pb-6 border-b border-neutral-100">
                    <div class="w-20 h-20 rounded-full bg-secondary-100 text-secondary-700 flex items-center justify-center text-3xl font-black">{{ mb_substr($patient->first_name, 0, 1) }}</div>
                    <div>
                        <h2 class="text-2xl font-black text-primary-950">{{ $patient->full_name }}</h2>
                        <p class="text-neutral-500 mt-1">رقم الملف #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-5 mt-6">
                    @foreach([
                        ['الجنس', $patient->gender === 'male' ? 'ذكر' : 'أنثى'],
                        ['تاريخ الميلاد', $patient->birth_date->format('Y-m-d')],
                        ['رقم الهاتف', $patient->phone],
                        ['فصيلة الدم', $patient->blood_type ?: 'غير محدد'],
                        ['العنوان', $patient->address ?: 'غير مسجل'],
                        ['جهة الطوارئ', $patient->emergency_contact ?: 'غير مسجلة']
                    ] as $item)
                        <div class="rounded-xl bg-neutral-50 p-4">
                            <p class="text-xs text-neutral-500 mb-1">{{ $item[0] }}</p>
                            <p class="font-bold text-primary-900">{{ $item[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
            @unless(auth()->user()->hasRole('receptionist'))
            <aside class="card p-5">
                <h3 class="font-bold text-primary-900 mb-4">ملخص الملف</h3>
                <div class="space-y-3">
                    <a href="{{ route('patients.record', $patient) }}" title="فتح السجل الطبي">
                        @foreach([
                            ['المواعيد', $patient->appointments_count],
                            ['السجلات الطبية', $patient->medical_records_count],
                            ['الفواتير', $patient->bills_count]
                        ] as $item)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-primary-50 mb-3 hover:bg-primary-100 transition">
                                <span class="text-sm text-neutral-600">{{ $item[0] }}</span>
                                <strong class="text-primary-700">{{ $item[1] }}</strong>
                            </div>
                        @endforeach
                    </a>
                </div>
                <div class="mt-6 pt-4 border-t border-neutral-100">
                    @if(auth()->user()->hasAnyRole(['admin', 'accountant']))
                    <a href="{{ route('bills.index') }}" class="block text-center w-full py-2 rounded-lg bg-secondary-600 text-white font-bold text-sm hover:bg-secondary-700 transition mb-2">
                        عرض الفواتير
                    </a>
                    @endif
                    <a href="{{ route('patients.record', $patient) }}"
                       class="block text-center w-full py-2 rounded-lg bg-primary-600 text-white font-bold text-sm hover:bg-primary-700 transition">
                        فتح السجل الطبي الكامل
                    </a>
                </div>
            </aside>
            @endunless
        </div>
    </div>
</x-app-layout>
