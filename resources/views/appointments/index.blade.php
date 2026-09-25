<x-app-layout>
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script crossorigin src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                <div>
                    <p class="text-primary-600 font-bold mb-2">إدارة المواعيد الطبية</p>
                    <h1 class="text-3xl font-black text-primary-950">المواعيد</h1>
                    <p class="text-neutral-500 mt-2">تنظيم مواعيد المرضى ومتابعة جدول الأطباء.</p>
                </div>
                <button id="appointments-header-create" type="button" class="btn-primary bg-secondary-600 hover:bg-secondary-700" onclick="window.location.href='{{ route('appointments.create') }}'">
                    {{ $isStaff ? '+ إضافة موعد جديد' : '+ حجز موعد جديد' }}
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-secondary-200 bg-secondary-50 px-5 py-3 text-secondary-700">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div id="appointments-root" class="card mt-6 overflow-hidden">
            @if($appointments->isEmpty())
                <div class="p-16 text-center text-neutral-500">
                    لا توجد مواعيد مسجلة {{ $isStaff ? 'بعد' : 'لك حتى الآن' }}.
                </div>
            @else
                <div class="overflow-x-auto pt-5">
                    <table class="w-full min-w-[850px] text-right">
                        <thead class="bg-primary-50 text-sm text-primary-900">
                            <tr>
                                @if($isStaff)<th class="px-5 py-4">المريض</th>@endif
                                <th class="px-5 py-4">الطبيب</th>
                                <th class="px-5 py-4">التخصص</th>
                                <th class="px-5 py-4">التاريخ</th>
                                <th class="px-5 py-4">الوقت</th>
                                <th class="px-5 py-4">الحالة</th>
                                <th class="px-5 py-4">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @foreach($appointments as $appointment)
                                @php
                                    $statusLabel = match($appointment->status) {
                                        'pending', 'قيد الانتظار' => 'قيد الانتظار',
                                        'confirmed', 'مؤكد' => 'مؤكد',
                                        'cancelled', 'ملغي' => 'ملغي',
                                        'completed' => 'مكتمل',
                                        'تم التأجيل' => 'تم التأجيل',
                                        default => $appointment->status ?: '-',
                                    };
                                    $statusClass = match($appointment->status) {
                                        'confirmed', 'مؤكد', 'completed' => 'badge badge-success',
                                        'pending', 'قيد الانتظار' => 'badge badge-warning',
                                        'cancelled', 'ملغي' => 'badge badge-danger',
                                        default => 'badge badge-info',
                                    };
                                @endphp
                                <tr class="table-row-hover">
                                    @if($isStaff)<td class="px-5 py-4 font-semibold text-primary-900">{{ $appointment->patient_name ?: '-' }}</td>@endif
                                    <td class="px-5 py-4 text-neutral-700">{{ $appointment->doctor_name ?: '-' }}</td>
                                    <td class="px-5 py-4 text-neutral-600">{{ $appointment->specialty ?: '-' }}</td>
                                    <td class="px-5 py-4 text-neutral-600">{{ $appointment->date?->format('Y-m-d') ?: $appointment->appointment_date?->format('Y-m-d') ?: '-' }}</td>
                                    <td class="px-5 py-4 text-neutral-600">{{ $appointment->time ?: ($appointment->appointment_date?->format('H:i') ?: '-') }}</td>
                                    <td class="px-5 py-4"><span class="{{ $statusClass }}">{{ $statusLabel }}</span></td>
                                    <td class="px-5 py-4 align-middle">
                                        <div class="flex flex-wrap items-center gap-2 min-w-[210px]">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-primary-50 px-3 py-2 text-sm font-bold text-primary-700 hover:bg-primary-100">عرض</a>
                                        @if($canManageAppointments)
                                            <a href="{{ route('appointments.edit', $appointment) }}" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-secondary-50 px-3 py-2 text-sm font-bold text-secondary-700 hover:bg-secondary-100">تعديل</a>
                                            <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="inline-flex" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-red-50 px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-100">حذف</button>
                                            </form>
                                        @endif
                                        @if(!$isStaff && $appointment->status !== 'cancelled' && ($appointment->appointment_date ?? \Illuminate\Support\Carbon::parse(($appointment->date?->toDateString() ?? $appointment->date).' '.($appointment->time ?? '00:00')))->isAfter(now()->addHours(24)))
                                            <form method="POST" action="{{ route('appointments.cancel', $appointment) }}" class="inline-flex" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الموعد؟')">
                                                @csrf
                                                <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg bg-red-50 px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-100">إلغاء الحجز</button>
                                            </form>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script type="text/plain">
        const statusLabel = (status) => ({
            pending: 'قيد الانتظار',
            confirmed: 'مؤكد',
            postponed: 'تم التأجيل',
            completed: 'مكتمل',
            cancelled: 'ملغي',
            'قيد الانتظار': 'قيد الانتظار',
            'مؤكد': 'مؤكد',
            'تم التأجيل': 'تم التأجيل',
            'ملغي': 'ملغي',
        }[status] || status || '-');

        const statusBadgeClass = (status) => {
            switch (status) {
                case 'confirmed': case 'مؤكد': return 'badge badge-success';
                case 'pending': case 'قيد الانتظار': return 'badge badge-warning';
                case 'postponed': case 'تم التأجيل': return 'badge badge-info';
                case 'completed': return 'badge badge-success';
                case 'cancelled': case 'ملغي': return 'badge badge-danger';
                default: return 'badge bg-neutral-100 text-neutral-600';
            }
        };

        const IS_STAFF = @json($isStaff ?? false);
        const CAN_MANAGE_APPOINTMENTS = @json($canManageAppointments ?? false);
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        function AppointmentsPage() {
            const [appointments] = React.useState(@json($appointments ?? []));
            const [loading] = React.useState(false);
            const [error, setError] = React.useState(null);

            const goToCreate = () => {
                window.location.href = "{{ route('appointments.create') }}";
            };

            const goToView = (id) => {
                window.location.href = `/appointments/${id}`;
            };

            const goToEdit = (id) => {
                window.location.href = `/appointments/${id}/edit`;
            };

            const handleDelete = (e, id) => {
                e.preventDefault();
                e.stopPropagation();
                if (!confirm('هل أنت متأكد من حذف هذا الموعد؟')) {
                    return;
                }
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/appointments/${id}`;
                form.style.display = 'none';
                form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value="${CSRF_TOKEN}" />
                `;
                document.body.appendChild(form);
                form.submit();
            };

            const headerTitle = IS_STAFF ? 'المواعيد' : 'مواعيدي';
            const headerDesc = IS_STAFF
                ? 'إدارة المواعيد الطبية وتنظيم جدول الأطباء'
                : 'متابعة جميع مواعيدك الطبية القادمة والسابقة';
            const emptyMsg = IS_STAFF ? 'لا توجد مواعيد مسجلة بعد.' : 'لا توجد مواعيد مسجلة لك حتى الآن.';
            const addBtnLabel = IS_STAFF ? '+ إضافة موعد جديد' : '+ حجز موعد جديد';

            return (
                <div className="appointments-content">
                    {loading && <div className="p-10 text-center text-neutral-500">جاري تحميل المواعيد...</div>}
                    {error && <div className="m-5 rounded-xl bg-red-50 px-5 py-4 text-red-700">خطأ: {error}</div>}

                    {!loading && !error && (
                        appointments.length === 0 ? (
                            <div className="p-16 text-center text-neutral-500">
                                <p>{emptyMsg}</p>
                            </div>
                        ) : (
                            <div className="overflow-x-auto pt-5">
                            <table className="w-full min-w-[850px] text-right">
                                <thead className="bg-primary-50 text-sm text-primary-900">
                                    <tr>
                                        {IS_STAFF && <th className="px-5 py-4">المريض</th>}
                                        <th className="px-5 py-4">الطبيب</th>
                                        <th className="px-5 py-4">التخصص</th>
                                        <th className="px-5 py-4">التاريخ</th>
                                        <th className="px-5 py-4">الوقت</th>
                                        <th className="px-5 py-4">الحالة</th>
                                        <th className="px-5 py-4">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-neutral-100">
                                    {appointments.map(a => (
                                        <tr key={a.id} className="table-row-hover">
                                            {IS_STAFF && <td className="px-5 py-4 font-semibold text-primary-900">{a.patient_name || '-'}</td>}
                                            <td className="px-5 py-4 text-neutral-700">{a.doctor_name || '-'}</td>
                                            <td className="px-5 py-4 text-neutral-600">{a.specialty || '-'}</td>
                                            <td className="px-5 py-4 text-neutral-600">{a.date ? new Date(a.date).toLocaleDateString('ar-EG') : (a.appointment_date ? new Date(a.appointment_date).toLocaleDateString('ar-EG') : '-')}</td>
                                            <td className="px-5 py-4 text-neutral-600">{a.time || '-'}</td>
                                            <td className="px-5 py-4">
                                                <span className={statusBadgeClass(a.status)}>
                                                    {statusLabel(a.status)}
                                                </span>
                                            </td>
                                            <td className="px-5 py-4">
                                                <button
                                                    type="button"
                                                    className="rounded-lg bg-primary-50 px-3 py-2 text-primary-700 hover:bg-primary-100"
                                                    onClick={() => goToView(a.id)}>
                                                    عرض
                                                </button>

                                                {CAN_MANAGE_APPOINTMENTS && (
                                                    <React.Fragment>
                                                        <button
                                                            type="button"
                                                            className="mr-2 rounded-lg bg-secondary-50 px-3 py-2 text-secondary-700 hover:bg-secondary-100"
                                                            onClick={() => goToEdit(a.id)}>
                                                            تعديل
                                                        </button>
                                                        <button
                                                            type="button"
                                                            className="mr-2 rounded-lg bg-red-50 px-3 py-2 text-red-600 hover:bg-red-100"
                                                            onClick={(e) => handleDelete(e, a.id)}>
                                                            حذف
                                                        </button>
                                                    </React.Fragment>
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            </div>
                        )
                    )}
                </div>
            );
        }

        ReactDOM.createRoot(document.getElementById('appointments-root'))
            .render(<AppointmentsPage />);
    </script>
</x-app-layout>
