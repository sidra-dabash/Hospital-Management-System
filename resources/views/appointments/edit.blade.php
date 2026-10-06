<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <a href="{{ route('appointments.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى قائمة المواعيد</a>
                    <h1 class="text-3xl font-black text-primary-950 mt-4">تعديل الموعد</h1>
                    <p class="text-neutral-500 mt-2">قم بتحديث بيانات الموعد وفقاً للتغييرات المطلوبة.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('appointments.show', ['appointment' => $appointment->id]) }}"
                       class="btn-secondary">
                        ← عرض التفاصيل
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 px-5 py-4 text-red-700">
                    <strong>فشل في تحديث الموعد:</strong>
                    <ul class="mt-2 pr-5">
                        @foreach($errors->all() as $e)
                            <li>• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
                <form class="space-y-5" method="POST" action="{{ route('appointments.update', ['appointment' => $appointment->id]) }}" novalidate>
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-bold text-primary-900 mb-2">المريض <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="patient_name"
                            value="{{ old('patient_name', $appointment->patient_name) }}"
                            placeholder="اسم المريض"
                            class="input-field @error('patient_name') border-red-500 bg-red-50 @enderror"
                        />
                        @error('patient_name')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary-900 mb-2">الطبيب <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="doctor_name"
                            value="{{ old('doctor_name', $appointment->doctor_name) }}"
                            placeholder="اسم الطبيب"
                            class="input-field @error('doctor_name') border-red-500 bg-red-50 @enderror"
                        />
                        @error('doctor_name')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary-900 mb-2">التخصص الطبي</label>
                        <input
                            type="text"
                            name="specialty"
                            value="{{ old('specialty', $appointment->specialty) }}"
                            placeholder="مثال: الباطنية، الأطفال، الجراحة..."
                            class="input-field"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-primary-900 mb-2">التاريخ <span class="text-red-500">*</span></label>
                            <input
                                type="date"
                                name="date"
                                value="{{ old('date', $appointment->date?->toDateString() ?? $appointment->appointment_date?->toDateString()) }}"
                                class="input-field @error('date') border-red-500 bg-red-50 @enderror"
                            />
                            @error('date')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-primary-900 mb-2">الوقت <span class="text-red-500">*</span></label>
                            <input
                                type="time"
                                name="time"
                                value="{{ old('time', $appointment->time) }}"
                                class="input-field @error('time') border-red-500 bg-red-50 @enderror"
                            />
                            @error('time')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary-900 mb-2">حالة الموعد <span class="text-red-500">*</span></label>
                        <select class="select-field" name="status">
                            <option value="confirmed" @selected(old('status', $appointment->status) === 'confirmed')>مؤكد</option>
                            <option value="pending" @selected(old('status', $appointment->status) === 'pending')>قيد الانتظار</option>
                            <option value="completed" @selected(old('status', $appointment->status) === 'completed')>مكتمل</option>
                            <option value="cancelled" @selected(old('status', $appointment->status) === 'cancelled')>ملغي</option>
                        </select>
                        @error('status')<div class="mt-1 text-sm text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-primary-900 mb-2">ملاحظات</label>
                        <textarea
                            name="notes"
                            rows="4"
                            placeholder="أي ملاحظات إضافية حول الموعد..." class="input-field min-h-28">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row gap-3 justify-end border-t border-neutral-100 pt-6">
                        <a href="{{ route('appointments.index') }}" class="btn-secondary">
                            إلغاء
                        </a>
                        <button type="submit" class="btn-primary">
                            حفظ التعديلات
                        </button>
                    </div>
                </form>

                <aside class="rounded-2xl border border-primary-100 bg-primary-50/50 p-5 h-fit">
                    <h3 class="text-lg font-bold text-primary-950">إرشادات تعديل الموعد</h3>
                    <ul class="mt-4 list-disc space-y-3 pr-5 text-sm leading-6 text-neutral-600">
                        <li>تأكد من صحة اسم المريض والطبيب.</li>
                        <li>يمكن اختيار تاريخ أقل من اليوم عند التعديل (لسجلات المراجعات).</li>
                        <li>غيّر الحالة وفقاً للوضع الحالي للموعد.</li>
                        <li>استخدم خانة الملاحظات لأي تفاصيل إضافية.</li>
                    </ul>
                    <div class="mt-6 rounded-xl border border-secondary-200 bg-secondary-50 p-4 text-sm text-secondary-800">
                        <h4 class="font-bold">ملاحظة هامة</h4>
                        <p class="mt-2">الحقول المعلمة بـ <span class="text-red-500">*</span> إلزامية ولا يمكن حفظ الموعد بدونها.</p>
                    </div>
                    <div class="my-5 border-t border-dashed border-neutral-200"></div>
                    <h4 class="mb-3 font-bold text-primary-950">إجراءات سريعة</h4>
                    <form method="POST" action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}"
                          onsubmit="return confirm('⚠️ هل أنت متأكد تماماً من حذف هذا الموعد؟ لا يمكن التراجع عن هذه العملية.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-xl border border-red-200 bg-red-50 px-4 py-3 font-bold text-red-600 hover:bg-red-100">
                            🗑️ حذف هذا الموعد
                        </button>
                    </form>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
