<x-app-layout>
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script crossorigin src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <a href="{{ route('appointments.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى قائمة المواعيد</a>
            <h1 class="text-3xl font-black text-primary-950 mt-4">{{ $isStaff ? 'إضافة موعد جديد' : 'حجز موعد جديد' }}</h1>
            <p class="text-neutral-500 mt-2">{{ $isStaff ? 'أدخل بيانات الموعد لتنظيم جدول الأطباء.' : 'قم بتعبئة البيانات التالية لحجز موعدك الطبي.' }}</p>
        </div>
        <div id="create-appointment-root"></div>
    </div>

    <script type="text/babel">
        const IS_STAFF = @json($isStaff ?? false);
        const IS_PATIENT = @json(auth()->user()->hasRole('patient'));
        const AVAILABLE_DOCTORS = @json($availableDoctors ?? []);
        const DEFAULT_PATIENT_NAME = @json($defaultPatientName ?? '');
        const IS_DOCTOR = @json(auth()->user()->hasRole('doctor'));
        const DEFAULT_DOCTOR_NAME = @json($defaultDoctorName ?? '');
        const DEFAULT_SPECIALTY = @json($defaultSpecialty ?? '');
        const DEFAULT_DOCTOR_ID = @json($defaultDoctorId ?? null);
        const DEFAULT_STATUS = IS_STAFF ? 'confirmed' : 'pending';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        const INDEX_URL = "{{ route('appointments.index') }}";
        const MIN_DATE = "{{ date('Y-m-d') }}";

        function CreateAppointmentPage() {
            const [form, setForm] = React.useState({
                patient_name: DEFAULT_PATIENT_NAME,
                doctor_name: DEFAULT_DOCTOR_NAME,
                doctor_id: IS_DOCTOR ? DEFAULT_DOCTOR_ID : '',
                specialty: DEFAULT_SPECIALTY,
                date: '',
                time: '',
                status: DEFAULT_STATUS,
                appointment_type: '',
                notes: '',
            });
            const [errors, setErrors] = React.useState({});
            const [submitting, setSubmitting] = React.useState(false);
            const [apiError, setApiError] = React.useState(null);

            const handleChange = (e) => {
                const { name, value } = e.target;
                if (name === 'doctor_id') {
                    const selectedDoctor = AVAILABLE_DOCTORS.find(doctor => String(doctor.id) === value);
                    setForm(prev => ({ ...prev, doctor_id: value, doctor_name: selectedDoctor ? selectedDoctor.name : '', specialty: selectedDoctor ? (selectedDoctor.specialty || '') : '' }));
                    setErrors(prev => {
                        const next = { ...prev };
                        delete next.doctor_id;
                        delete next.doctor_name;
                        return next;
                    });
                    return;
                }
                setForm(prev => ({ ...prev, [name]: value }));
                if (errors[name]) {
                    setErrors(prev => {
                        const n = { ...prev };
                        delete n[name];
                        return n;
                    });
                }
            };

            const validateForm = () => {
                const newErrors = {};
                if (!form.patient_name.trim()) newErrors.patient_name = 'اسم المريض مطلوب';
                if (!form.doctor_name.trim()) newErrors.doctor_name = 'اسم الطبيب مطلوب';
                if (IS_PATIENT && !form.doctor_id) newErrors.doctor_id = 'يرجى اختيار الطبيب';
                if (!form.date) newErrors.date = 'تاريخ الموعد مطلوب';
                if (!form.time) newErrors.time = 'وقت الموعد مطلوب';
                setErrors(newErrors);
                return Object.keys(newErrors).length === 0;
            };

            const handleSubmit = (e) => {
                e.preventDefault();
                setApiError(null);
                if (!validateForm()) return;

                setSubmitting(true);

                const payload = {
                    patient_name: form.patient_name,
                    doctor_name: form.doctor_name,
                    specialty: IS_DOCTOR ? DEFAULT_SPECIALTY : (IS_PATIENT ? form.specialty : (form.specialty || form.appointment_type)),
                    doctor_id: form.doctor_id || null,
                    date: form.date,
                    time: form.time,
                    status: form.status,
                    notes: form.notes,
                };

                fetch('/api/appointments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload),
                })
                .then(async (res) => {
                    const data = await res.json();
                    if (!res.ok) {
                        if (data.errors) setErrors(data.errors);
                        throw new Error(data.message || 'فشل في حفظ الموعد');
                    }
                    return data;
                })
                .then(() => {
                    window.location.href = INDEX_URL;
                })
                .catch((err) => {
                    setApiError(err.message);
                    setSubmitting(false);
                });
            };

            const cancel = () => {
                window.location.href = INDEX_URL;
            };

            const pageTitle = IS_STAFF ? 'إضافة موعد جديد' : 'حجز موعد جديد';
            const pageDesc = IS_STAFF
                ? 'قم بإدخال بيانات الموعد الجديد بدقة لضمان تنظيم جدول الأطباء.'
                : 'قم بتعبئة البيانات التالية لحجز موعدك الطبي.';

            return (
                <div className="card p-6 sm:p-8">
                    {apiError && <div className="mb-6 rounded-xl bg-red-50 px-5 py-4 text-red-700">{apiError}</div>}

                    <div className="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-8">
                        <form className="space-y-5" onSubmit={handleSubmit} noValidate>
                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">المريض <span className="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    name="patient_name"
                                    value={form.patient_name}
                                    onChange={handleChange}
                                    placeholder="اسم المريض"
                                    className={`input-field ${errors.patient_name ? 'border-red-500 bg-red-50' : ''}`}
                                    readOnly={!IS_STAFF}
                                    style={!IS_STAFF ? {background:'#f5f5f5',cursor:'not-allowed'} : {}}
                                />
                                {errors.patient_name && <div className="mt-1 text-sm text-red-600">{errors.patient_name}</div>}
                                {!IS_STAFF && (
                                    <div style={Object.assign({}, { fontSize: '12px', color: '#666', marginTop: '4px' })}>
                                        لا يمكن تغيير اسم المريض عند الحجز من حساب المريض.
                                    </div>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">الطبيب <span className="text-red-500">*</span></label>
                                {IS_PATIENT ? (
                                    <select name="doctor_id" value={form.doctor_id} onChange={handleChange} className={`select-field ${errors.doctor_id ? 'border-red-500 bg-red-50' : ''}`} required>
                                        <option value="">اختر الطبيب</option>
                                        {AVAILABLE_DOCTORS.map(doctor => <option key={doctor.id} value={doctor.id}>{doctor.name}</option>)}
                                    </select>
                                ) : <input
                                    type="text"
                                    name="doctor_name"
                                    value={form.doctor_name}
                                    onChange={handleChange}
                                    placeholder="اسم الطبيب"
                                    className={`input-field ${errors.doctor_name ? 'border-red-500 bg-red-50' : ''}`}
                                    readOnly={IS_DOCTOR}
                                    style={IS_DOCTOR ? {background:'#f5f5f5',cursor:'not-allowed'} : {}}
                                />}
                                {errors.doctor_name && <div className="mt-1 text-sm text-red-600">{errors.doctor_name}</div>}
                                {errors.doctor_id && <div className="mt-1 text-sm text-red-600">{errors.doctor_id}</div>}
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">التخصص الطبي</label>
                                {IS_PATIENT ? (
                                    <select name="specialty" value={form.specialty} onChange={handleChange} className="select-field" disabled={!form.doctor_id}>
                                        {!form.doctor_id && <option value="">اختر الطبيب أولاً</option>}
                                        {form.doctor_id && <option value={form.specialty}>{form.specialty || 'لا يوجد تخصص مسجل'}</option>}
                                    </select>
                                ) : <input
                                    type="text"
                                    name="specialty"
                                    value={form.specialty}
                                    onChange={handleChange}
                                    placeholder="مثال: الباطنية، الأطفال، الجراحة..."
                                    className="input-field"
                                    readOnly={IS_DOCTOR}
                                    style={IS_DOCTOR ? {background:'#f5f5f5',cursor:'not-allowed'} : {}}
                                />}
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label className="block text-sm font-bold text-primary-900 mb-2">التاريخ <span className="text-red-500">*</span></label>
                                    <input
                                        type="date"
                                        name="date"
                                        value={form.date}
                                        onChange={handleChange}
                                        min={MIN_DATE}
                                        className={`input-field ${errors.date ? 'border-red-500 bg-red-50' : ''}`}
                                    />
                                    {errors.date && <div className="mt-1 text-sm text-red-600">{errors.date}</div>}
                                </div>
                                <div>
                                    <label className="block text-sm font-bold text-primary-900 mb-2">الوقت <span className="text-red-500">*</span></label>
                                    <input
                                        type="time"
                                        name="time"
                                        value={form.time}
                                        onChange={handleChange}
                                        className={`input-field ${errors.time ? 'border-red-500 bg-red-50' : ''}`}
                                    />
                                    {errors.time && <div className="mt-1 text-sm text-red-600">{errors.time}</div>}
                                </div>
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">نوع الموعد</label>
                                <select className="select-field" name="appointment_type" value={form.appointment_type} onChange={handleChange}>
                                    <option value="">اختر نوع الموعد</option>
                                    <option value="استشارة">استشارة</option>
                                    <option value="متابعة">متابعة</option>
                                    <option value="فحص دوري">فحص دوري</option>
                                    <option value="جراحة">جراحة</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">حالة الموعد <span className="text-red-500">*</span></label>
                                {IS_STAFF ? (
                                    <select className="select-field" name="status" value={form.status} onChange={handleChange}>
                                        <option value="confirmed">مؤكد</option>
                                        <option value="pending">قيد الانتظار</option>
                                        <option value="completed">مكتمل</option>
                                        <option value="cancelled">ملغي</option>
                                    </select>
                                ) : (
                                    <input
                                        type="text"
                                        name="status_display"
                                        value="سيتم تأكيد الموعد من إدارة المشفى"
                                        readOnly
                                        className="input-field bg-neutral-100 text-neutral-500"
                                    />
                                )}
                                {!IS_STAFF && (
                                    <input type="hidden" name="status" value={form.status} readOnly />
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-bold text-primary-900 mb-2">ملاحظات</label>
                                <textarea
                                    name="notes"
                                    value={form.notes}
                                    onChange={handleChange}
                                    rows="4"
                                    placeholder="أي ملاحظات إضافية حول الموعد..."
                                    className="input-field min-h-28"
                                />
                            </div>

                            <div className="flex flex-col-reverse sm:flex-row gap-3 justify-end border-t border-neutral-100 pt-6">
                                <button type="button" className="btn-secondary" onClick={cancel} disabled={submitting}>
                                    إلغاء
                                </button>
                                <button type="submit" className="btn-primary" disabled={submitting}>
                                    {submitting ? 'جاري الحفظ...' : (IS_STAFF ? 'حفظ الموعد' : 'تأكيد الحجز')}
                                </button>
                            </div>
                        </form>

                        <aside className="rounded-2xl border border-primary-100 bg-primary-50/50 p-5 h-fit">
                            <h3 className="text-lg font-bold text-primary-950">إرشادات {IS_STAFF ? 'إضافة الموعد' : 'الحجز'}</h3>
                            <ul className="mt-4 list-disc space-y-3 pr-5 text-sm leading-6 text-neutral-600">
                                <li>تأكد من صحة اسم المريض والطبيب.</li>
                                <li>اختر التاريخ والوقت بما يتناسب مع جدول الطبيب.</li>
                                <li>لا يمكن اختيار تاريخ أقل من تاريخ اليوم.</li>
                                {IS_STAFF && <li>حدد حالة الموعد بدقة (مؤكد، قيد الانتظار، إلخ).</li>}
                                {!IS_STAFF && <li>بعد تقديم الحجز سيتم التواصل معك لتأكيد الموعد.</li>}
                                <li>استخدم خانة الملاحظات لأي تفاصيل إضافية.</li>
                            </ul>
                            <div className="mt-6 rounded-xl border border-secondary-200 bg-secondary-50 p-4 text-sm text-secondary-800">
                                <h4 className="font-bold">ملاحظة هامة</h4>
                                <p className="mt-2">الحقول المعلمة بـ <span className="text-red-500">*</span> إلزامية ولا يمكن حفظ الموعد بدونها.</p>
                            </div>
                        </aside>
                    </div>
                </div>
            );
        }

        ReactDOM.createRoot(document.getElementById('create-appointment-root'))
            .render(<CreateAppointmentPage />);
    </script>
</x-app-layout>
