<x-app-layout>
    @php($recordBackUrl = auth()->user()?->hasRole('patient') ? route('dashboard') : route('patients.show', $patientId))

    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-10 sm:py-12">
            <a href="{{ $recordBackUrl }}" class="text-primary-600 font-bold text-sm hover:text-secondary-700">← العودة</a>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mt-6">
                <div>
                    <p class="text-primary-600 font-bold text-sm mb-1">ملف المريض</p>
                    <h1 class="text-2xl sm:text-3xl font-black text-primary-950">السجل الطبي للمريض</h1>
                </div>
                <p class="text-sm text-neutral-500">المتابعة الطبية والتاريخ الصحي</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-5 sm:pb-6">
        @include('partials.flash')
        <div id="medical-record-root" data-patient-id="{{ $patientId }}"></div>
    </div>

    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script crossorigin src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

    <script type="text/babel">
        function MedicalRecordPage() {
            const root = document.getElementById('medical-record-root');
            const patientId = root.dataset.patientId;

            const [data, setData] = React.useState(null);
            const [loading, setLoading] = React.useState(true);
            const [error, setError] = React.useState(null);

            React.useEffect(() => {
                setLoading(true);
                setError(null);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch(`/api/patients/${patientId}/record`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                })
                    .then(res => {
                        if (!res.ok) throw new Error('فشل في جلب بيانات السجل الطبي');
                        return res.json();
                    })
                    .then(d => {
                        setData(d);
                        setLoading(false);
                    })
                    .catch(err => {
                        setError(err.message);
                        setLoading(false);
                    });
            }, [patientId]);

            if (loading) {
                return (
                    <div className="card p-12 text-center text-neutral-500">
                        <div className="w-10 h-10 mx-auto mb-4 rounded-full border-4 border-primary-100 border-t-primary-600 animate-spin"></div>
                        <p>جاري تحميل السجل الطبي...</p>
                    </div>
                );
            }

            if (error) {
                return (
                    <div className="card p-8 text-center text-red-600">
                        <p>⚠️ خطأ: {error}</p>
                        <button className="btn-blue mt-4" onClick={() => window.location.reload()}>إعادة المحاولة</button>
                    </div>
                );
            }

            const valueOrFallback = (value) => value || 'غير مسجل';

            return (
                <div className="space-y-8" dir="rtl">
                    <section className="card overflow-hidden">
                        <div className="flex flex-col sm:flex-row sm:items-center gap-3 p-5 sm:p-6 bg-primary-50/60 border-b border-primary-100 text-right">
                            <div className="flex-1 min-w-0 text-right">
                                <h2 className="text-xl font-black text-primary-950">{data.name}</h2>
                                <p className="text-sm text-neutral-500 mt-1">رقم الملف: {data.national_id}</p>
                            </div>
                            <div className="badge badge-success self-start sm:self-center shrink-0">{data.status}</div>
                        </div>
                        <div className="p-6 sm:p-8">
                            <h3 className="text-base font-bold text-primary-900 mb-5">البيانات الأساسية</h3>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">العمر</p><strong className="text-sm text-primary-900">{data.age} سنة</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">الجنس</p><strong className="text-sm text-primary-900">{data.gender}</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">تاريخ الميلاد</p><strong className="text-sm text-primary-900">{data.birth_date}</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">رقم التواصل</p><strong className="text-sm text-primary-900">{data.phone}</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">فصيلة الدم</p><strong className="text-sm text-primary-900">{data.blood_type}</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4"><p className="text-xs text-neutral-500 mb-2">العنوان</p><strong className="text-sm text-primary-900">{data.address}</strong></div>
                                <div className="rounded-xl border border-neutral-100 bg-white p-4 sm:col-span-2"><p className="text-xs text-neutral-500 mb-2">جهة الطوارئ</p><strong className="text-sm text-primary-900">{data.emergency_contact}</strong></div>
                            </div>
                        </div>
                    </section>

                    <section className="mt-8">
                        <h2 className="text-lg font-black text-primary-950 mb-5">ملخص الحالة الطبية</h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div className="card p-5 border-t-4 border-t-secondary-500"><div className="text-xs text-neutral-500">الأدوية الحالية</div><div className="text-2xl font-black text-primary-700 mt-2">{data.current_medications}</div>
                        </div>
                        <div className="card p-5 border-t-4 border-t-primary-500"><div className="text-xs text-neutral-500">التشخيصات</div><div className="text-2xl font-black text-primary-700 mt-2">{data.diagnoses}</div>
                        </div>
                        <div className="card p-5 border-t-4 border-t-primary-400"><div className="text-xs text-neutral-500">الفحوصات</div><div className="text-2xl font-black text-primary-700 mt-2">{data.tests}</div>
                        </div>
                        <div className="card p-5 border-t-4 border-t-secondary-500"><div className="text-xs text-neutral-500">المواعيد القادمة</div><div className="text-2xl font-black text-primary-700 mt-2">{data.upcoming_appointments}</div>
                        </div>
                        </div>
                    </section>

                    <section className="card p-6 sm:p-8 mt-8">
                        <div className="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h2 className="text-xl font-black text-primary-950">التاريخ الطبي</h2>
                                <p className="text-sm text-neutral-500 mt-1">آخر الأحداث والزيارات الطبية مرتبة من الأحدث</p>
                            </div>
                            <span className="badge badge-info">{data.recent_records ? data.recent_records.length : 0} سجل</span>
                        </div>
                        {!data.recent_records || data.recent_records.length === 0 ? (
                            <div className="rounded-xl border border-dashed border-primary-200 bg-primary-50/40 p-8 text-center">
                                <div className="w-12 h-12 mx-auto rounded-full bg-white text-primary-600 flex items-center justify-center text-xl shadow-sm">+</div>
                                <p className="font-bold text-primary-900 mt-3">لا توجد سجلات طبية بعد</p>
                                <p className="text-sm text-neutral-500 mt-1">ستظهر الزيارات والتشخيصات هنا عند تسجيلها.</p>
                            </div>
                        ) : (
                            <div className="relative space-y-4 before:absolute before:right-[7px] before:top-2 before:bottom-2 before:w-px before:bg-primary-100">
                                {data.recent_records.map((r, idx) => (
                                    <article className="relative pr-8" key={idx}>
                                        <span className="absolute right-0 top-5 w-4 h-4 rounded-full bg-secondary-500 border-4 border-white shadow-sm"></span>
                                        <div className="rounded-xl border border-neutral-100 bg-white p-4 shadow-sm">
                                            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 mb-3 border-b border-neutral-100">
                                                <div className="flex items-center gap-2">
                                                    <span className="badge badge-info">{r.type}</span>
                                                    <span className="text-sm font-bold text-primary-900">{r.title}</span>
                                                </div>
                                                <time className="text-xs text-neutral-500">{r.date}</time>
                                            </div>
                                            <div className="grid sm:grid-cols-2 gap-x-5 gap-y-3 text-sm">
                                                <div><span className="text-xs text-neutral-500 block mb-1">الطبيب</span><strong className="text-neutral-800">{valueOrFallback(r.doctor || (r.type === 'زيارة طبية' ? r.subtitle : r.type === 'موعد طبي' ? r.title : ''))}</strong></div>
                                                <div><span className="text-xs text-neutral-500 block mb-1">التشخيص</span><strong className="text-neutral-800">{valueOrFallback(r.diagnosis || (r.type === 'زيارة طبية' ? r.title : ''))}</strong></div>
                                                {r.tests && <div><span className="text-xs text-neutral-500 block mb-1">الفحوصات</span><span className="text-neutral-700">{r.tests}</span></div>}
                                                {r.treatment && <div><span className="text-xs text-neutral-500 block mb-1">العلاج</span><span className="text-neutral-700">{r.treatment}</span></div>}
                                                {r.prescription && <div><span className="text-xs text-neutral-500 block mb-1">الأدوية والوصفة</span><span className="text-neutral-700">{r.prescription}</span></div>}
                                                {r.notes && <div className="sm:col-span-2"><span className="text-xs text-neutral-500 block mb-1">الملاحظات</span><span className="text-neutral-700">{r.notes}</span></div>}
                                            </div>
                                        </div>
                                    </article>
                                ))}
                            </div>
                        )}
                    </section>
                </div>
            );
        }

        ReactDOM.createRoot(document.getElementById('medical-record-root'))
            .render(<MedicalRecordPage />);
    </script>
</x-app-layout>
