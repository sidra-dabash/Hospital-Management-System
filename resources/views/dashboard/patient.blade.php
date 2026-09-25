<x-app-layout>

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden bg-cover bg-center"
             style="background-image: url('{{ asset('images/nav.png') }}');">

        <div class="absolute inset-0 bg-white/85"></div>

        <div class="relative max-w-7xl mx-auto px-6 pt-24 pb-8 sm:pt-28 sm:pb-10">

            <div class="max-w-2xl mr-auto text-right">
                <div style="transform: translateY(60px); margin-bottom: 90px;">
                    <p class="text-secondary-600 font-bold text-base mb-3">
                        أهلاً بك يا {{ auth()->user()->name ?? 'مريضنا الكريم' }}
                    </p>

                    <h1 class="text-4xl sm:text-5xl font-black
                               leading-tight text-primary-950">

                        صحتك أولويتنا
                        <span class="block text-secondary-600 mt-2">
                            ورعايتك أسهل معنا
                        </span>

                    </h1>

                    <p class="text-primary-800 text-base sm:text-lg
                              leading-8 mt-7">

                        منصة Vivio تساعدك على متابعة رحلتك العلاجية،
                        مواعيدك الطبية، وسجلك الصحي بكل سهولة وأمان.

                    </p>
                </div>

            </div>

        </div>

    </section>


    {{-- ================= PATIENT STATISTICS ================= --}}
    <section class="max-w-7xl mx-auto px-5 sm:px-8 mt-8">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Upcoming Appointments --}}
            <div class="card p-5 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-sm text-neutral-500">المواعيد القادمة</p>
                    <strong class="block text-2xl font-black text-primary-700 mt-1">
                        {{ $patientAppointments ?? 0 }}
                    </strong>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-xl">
                    📅
                </div>
            </div>

            {{-- Medical Records --}}
            <div class="card p-5 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-sm text-neutral-500">السجلات الطبية</p>
                    <strong class="block text-2xl font-black text-secondary-600 mt-1">
                        {{ $medicalRecordsCount ?? 0 }}
                    </strong>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-secondary-50 flex items-center justify-center text-xl">
                    📋
                </div>
            </div>

            {{-- Bills --}}
            <div class="card p-5 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-sm text-neutral-500">الفواتير</p>
                    <strong class="block text-2xl font-black text-purple-600 mt-1">
                        {{ $billsCount ?? 0 }}
                    </strong>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-xl">
                    💳
                </div>
            </div>

            {{-- Prescriptions / Medications --}}
            <div class="card p-5 flex items-center justify-between">
                <div class="text-right">
                    <p class="text-sm text-neutral-500">الأدوية الحالية</p>
                    <strong class="block text-2xl font-black text-pink-600 mt-1">
                        {{ $prescriptionsCount ?? 0 }}
                    </strong>
                </div>

                <div class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center text-xl">
                    💊
                </div>
            </div>

        </div>
    </section>


    {{-- ================= QUICK SERVICES ================= --}}
    <section id="services"
             class="max-w-6xl mx-auto px-6 py-12">

        <div class="text-center mb-8">

            <p class="text-secondary-600 font-bold text-sm">
                خدماتك الشخصية
            </p>

            <h2 class="text-2xl sm:text-3xl font-black
                       text-primary-950 mt-2">

                خدماتك الصحية في مكان واحد

            </h2>

            <p class="text-neutral-500 text-sm mt-2">
                وصول سريع لأهم الخدمات التي تحتاجها كمريض
            </p>

        </div>


        {{-- Patient Services Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">


            {{-- Book Appointment --}}
            <a href="{{ route('appointments.create') }}"
               class="group h-full bg-white rounded-2xl
                      border border-neutral-100
                      p-6 text-center
                      shadow-sm hover:shadow-md
                      hover:-translate-y-1
                      transition-all duration-200">

                <div class="w-14 h-14 mx-auto rounded-2xl
                            bg-primary-50
                            text-primary-700
                            flex items-center justify-center
                            text-2xl font-bold">

                    📅

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    حجز موعد

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    احجز موعدك الطبي مع الطبيب
                    الذي تريد بكل سهولة.

                </p>

                <span class="inline-block
                             text-primary-700
                             text-sm font-bold mt-4 group-hover:text-secondary-600 transition">

                    احجز الآن ←

                </span>

            </a>


            {{-- My Appointments --}}
            <a href="{{ route('appointments.index') }}"
               class="group h-full bg-white rounded-2xl
                      border border-neutral-100
                      p-6 text-center
                      shadow-sm hover:shadow-md
                      hover:-translate-y-1
                      transition-all duration-200">

                <div class="w-14 h-14 mx-auto rounded-2xl
                            bg-secondary-50
                            text-secondary-600
                            flex items-center justify-center
                            text-2xl font-bold">

                    📆

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    مواعيدي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    اطلع على جميع مواعيدك الطبية
                    القادمة والسابقة.

                </p>

                <span class="inline-block
                             text-secondary-600
                             text-sm font-bold mt-4">

                    عرض المواعيد ←

                </span>

            </a>


            {{-- Medical Record --}}
            @if(!empty($patientRecordUrl))
            <a href="{{ $patientRecordUrl }}"
               id="my-records"
               class="group h-full bg-white rounded-2xl
                      border border-neutral-100
                      p-6 text-center
                      shadow-sm hover:shadow-md
                      hover:-translate-y-1
                      transition-all duration-200">
            @else
            <div id="my-records"
                   class="group h-full bg-white rounded-2xl
                        border border-neutral-100
                        p-6 text-center
                       shadow-sm hover:shadow-md
                       hover:-translate-y-1
                       transition-all duration-200">
            @endif

                <div class="w-14 h-14 mx-auto rounded-2xl
                            bg-emerald-50
                            text-emerald-600
                            flex items-center justify-center
                            text-2xl font-bold">

                    📋

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    سجلي الطبي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    اطلع على سجلك الصحي، التشخيصات،
                    والأدوية التي وصفت لك.

                </p>

                @if(!empty($patientRecordUrl))
                <span class="inline-block
                             text-emerald-600
                             text-sm font-bold mt-4">

                    عرض السجل ←

                </span>
                @else
                <span class="inline-block
                             text-neutral-400
                             text-sm font-bold mt-4">

                    (اطلب من الطبيب ربط ملفك)

                </span>
                @endif

            @if(!empty($patientRecordUrl))
            </a>
            @else
            </div>
            @endif


            {{-- Profile --}}
            <a href="{{ route('profile.edit') }}"
               class="group h-full bg-white rounded-2xl
                      border border-neutral-100
                      p-6 text-center
                      shadow-sm hover:shadow-md
                      hover:-translate-y-1
                      transition-all duration-200">

                <div class="w-14 h-14 mx-auto rounded-2xl
                            bg-amber-50
                            text-amber-600
                            flex items-center justify-center
                            text-2xl font-bold">

                    👤

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    الملف الشخصي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    عدّل بياناتك الشخصية، معلومات الاتصال،
                    وكلمة المرور.

                </p>

                <span class="inline-block
                             text-amber-600
                             text-sm font-bold mt-4">

                    تعديل البيانات ←

                </span>

            </a>


        </div>

    </section>


    {{-- ================= UPCOMING APPOINTMENTS ================= --}}
    <section class="max-w-6xl mx-auto px-6 pb-10">

        <div class="rounded-2xl
                    border border-primary-100
                    bg-gradient-to-l from-primary-50
                    to-secondary-50
                    px-7 py-8 sm:px-10">

            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">

                <div class="text-right mr-auto px-10 pt-12 pb-8">
                    <p class="text-secondary-600
                              font-bold text-sm ">

                        متابعة رحلتك

                    </p>

                    <h2 class="text-2xl sm:text-3xl
                               font-black text-primary-950 mt-2">

                        مواعيدك القادمة

                    </h2>
                </div>

                <a href="{{ route('appointments.index') }}"
                   class="text-sm font-bold text-primary-700
                          hover:text-secondary-600 transition">

                    عرض الكل ←

                </a>

            </div>

            <div class="space-y-3">

                @if(!empty($nextAppointments) && count($nextAppointments) > 0)

                    @foreach($nextAppointments as $app)

                        <div class="flex items-center justify-between
                                    bg-white rounded-xl
                                    px-5 py-4 shadow-sm
                                    border border-neutral-100">

                            <div class="text-right">

                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-lg">🩺</span>
                                    <strong class="text-primary-950 font-black">
                                        {{ $app->doctor_name ?? (isset($app->doctor) ? 'د. '.$app->doctor->first_name.' '.$app->doctor->last_name : 'طبيب') }}
                                    </strong>
                                </div>

                                <p class="text-sm text-neutral-500">
                                    {{ $app->specialty ?? 'استشارة طبية' }}
                                </p>

                            </div>

                            <div class="text-left">
                                <div class="text-sm font-bold text-secondary-600">
                                    {{ $app->date ? \Carbon\Carbon::parse($app->date)->format('Y-m-d') : (isset($app->appointment_date) ? $app->appointment_date->toDateString() : '-') }}
                                </div>
                                <div class="text-xs text-neutral-500 mt-1">
                                    الساعة {{ $app->time ?? ($app->appointment_date ? $app->appointment_date->format('H:i') : '-') }}
                                </div>
                                <span class="inline-block mt-2
                                             text-xs font-bold
                                             px-3 py-1 rounded-full
                                             bg-primary-50 text-primary-700
                                             border border-primary-100">
                                    {{ $app->status ?? 'مؤكد' }}
                                </span>
                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="bg-white rounded-xl
                                px-6 py-8 text-center
                                border border-dashed border-neutral-200">

                        <div class="text-4xl mb-3 opacity-40">📭</div>

                        <h3 class="font-black text-lg text-neutral-700">
                            لا توجد مواعيد قادمة حالياً
                        </h3>

                        <p class="text-sm text-neutral-500 mt-2 leading-relaxed">
                            يمكنك حجز موعد طبي جديد من خلال الضغط على الزر أدناه.
                        </p>

                        <a href="{{ route('appointments.create') }}"
                           class=" mt-5 inline-flex items-center gap-2
                                  px-5 py-3 rounded-xl
                                  bg-primary-700 text-black font-bold
                                  hover:bg-primary-800 transition
                                  ">

                            حجز موعد جديد
                            <span>←</span>

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </section>


</x-app-layout>
