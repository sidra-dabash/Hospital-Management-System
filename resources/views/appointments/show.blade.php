<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <a href="{{ route('appointments.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى قائمة المواعيد</a>
                    <h1 class="text-3xl font-black text-primary-950 mt-4">تفاصيل الموعد</h1>
                    <p class="text-neutral-500 mt-2">عرض كامل لجميع بيانات هذا الموعد الطبي.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($isStaff)
                        <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}"
                           class="btn-primary">
                            تعديل الموعد
                        </a>
                    @endif
                </div>
            </div>

            @php
                $statusLabels = [
                    'pending' => 'قيد الانتظار',
                    'confirmed' => 'مؤكد',
                    'cancelled' => 'ملغي',
                    'completed' => 'مكتمل',
                    'قيد الانتظار' => 'قيد الانتظار',
                    'مؤكد' => 'مؤكد',
                    'تم التأجيل' => 'تم التأجيل',
                    'ملغي' => 'ملغي',
                ];
                $statusClass = match($appointment->status) {
                    'confirmed', 'مؤكد', 'completed' => 'badge badge-success',
                    'pending', 'قيد الانتظار' => 'badge badge-warning',
                    'تم التأجيل' => 'badge badge-info',
                    'cancelled', 'ملغي' => 'badge badge-danger',
                    default => 'badge bg-neutral-100 text-neutral-600',
                };
                $statusLabel = $statusLabels[$appointment->status] ?? ($appointment->status ?: '-');
            @endphp

            <section class="card p-6">

                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-neutral-100 pb-6">
                    <div>
                    <h2 class="text-2xl font-black text-primary-950">
                        موعد: {{ $appointment->patient_name ?? 'غير محدد' }} مع د. {{ $appointment->doctor_name ?? 'غير محدد' }}
                    </h2>
                    <p class="mt-1 text-sm text-neutral-500">
                        {{ $appointment->specialty ? ('التخصص: ' . $appointment->specialty) : '' }}
                    </p>
                    </div>
                    <span class="{{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-6">

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">اسم المريض</div>
                        <div class="font-bold text-primary-900">{{ $appointment->patient_name ?? '-' }}</div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">اسم الطبيب</div>
                        <div class="font-bold text-primary-900">{{ $appointment->doctor_name ?? '-' }}</div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">التخصص</div>
                        <div class="font-bold text-primary-900">{{ $appointment->specialty ?? '-' }}</div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">التاريخ</div>
                        <div class="font-bold text-primary-900">
                        @if($appointment->date)
                            {{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d (l)') }}
                        @elseif($appointment->appointment_date)
                            {{ $appointment->appointment_date->toDateString() }}
                        @else
                            -
                        @endif
                        </div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">الوقت</div>
                        <div class="font-bold text-primary-900">{{ $appointment->time ?? '-' }}</div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4">
                        <div class="text-xs text-neutral-500 mb-1">الحالة</div>
                        <div class="font-bold text-primary-900">
                            <span class="{{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="rounded-xl bg-neutral-50 p-4 sm:col-span-2">
                        <div class="text-xs text-neutral-500 mb-1">الملاحظات</div>
                        <div class="font-medium leading-8 whitespace-pre-wrap text-primary-900">
                            {{ $appointment->notes ?: 'لا توجد ملاحظات إضافية.' }}
                        </div>
                    </div>

                </div>
            </section>
        </div>
</x-app-layout>
