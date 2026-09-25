<x-app-layout>

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden bg-cover bg-center"
             style="background-image: url('{{ asset('images/nav.png') }}');">

        <div class="absolute inset-0 bg-white/80"></div>

        <div class="relative max-w-7xl mx-auto px-6 pt-24 pb-40 sm:pt-28 sm:pb-44">

            <div class="max-w-2xl mr-auto text-right">

                <div style="margin-top: 40px; margin-bottom: 40px;">
                    <p class="text-secondary-600 font-bold text-base mb-3">
                        أهلاً بك في Vivio
                    </p>

                    <h1 class="text-4xl sm:text-5xl font-black
                               leading-tight text-primary-950">

                        صحتك أولويتنا
                        <span class="block text-secondary-600 mt-2">
                            ورعايتك أسهل معنا
                        </span>

                    </h1>

                    <p class="text-primary-800 text-base sm:text-lg
                              leading-8 mt-5">

                        منصة صحية تساعدك على الوصول إلى خدمات المشفى
                        ومتابعة رحلتك العلاجية بسهولة وأمان.

                    </p>
                </div>

            </div>

        </div>

    </section>


    {{-- ================= SERVICES ================= --}}
    <section id="services"
             class="max-w-6xl mx-auto px-6 py-12">

        <div class="text-center mb-8">

            <p class="text-secondary-600 font-bold text-sm">
                خدمات Vivio
            </p>

            <h2 class="text-2xl sm:text-3xl font-black
                       text-primary-950 mt-2">

                خدماتك الصحية في مكان واحد

            </h2>

            <p class="text-neutral-500 text-sm mt-2">
                وصول سريع إلى أهم مهامك اليومية كطبيب
            </p>

        </div>


        {{-- Services --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">


            {{-- Patients --}}
            <a href="{{ route('patients.index') }}"
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
                            text-xl font-bold">

                    +

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    مرضاي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    إدارة ملفات المرضى ومتابعة حالتهم
                    الصحية بسهولة.

                </p>

                <span class="inline-block
                             text-secondary-600
                             text-sm font-bold mt-4">

                    عرض المرضى ←

                </span>

            </a>


            {{-- Appointments --}}
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
                            text-xl font-bold">

                    +

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    مواعيدي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    تابع مواعيدك الطبية ومعلومات زياراتك
                    بسهولة.

                </p>

                <span class="inline-block
                             text-secondary-600
                             text-sm font-bold mt-4">

                    عرض المواعيد ←

                </span>

            </a>


                {{-- Personal Profile --}}
                <a href="{{ route('profile.edit') }}"
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
                            text-xl font-bold">

                    +

                </div>

                <h3 class="text-lg font-black
                           text-primary-950 mt-4">

                    ملفي الشخصي

                </h3>

                <p class="text-sm text-neutral-500
                          leading-6 mt-2">

                    عدّل بيانات حسابك الشخصي
                    بسهولة.

                </p>

                <span class="inline-block text-secondary-600 text-sm font-bold mt-4">

                    عرض الملف الشخصي ←

                </span>

            </a>

        </div>

    </section>


    {{-- ================= ABOUT ================= --}}
    <section class="max-w-6xl mx-auto px-6 pt-4 pb-0">

        <div class="rounded-2xl
                    border border-primary-100
                    bg-gradient-to-l from-primary-50
                    to-secondary-50
                    px-8 pt-6 pb-6 sm:px-12 sm:pt-8 sm:pb-8">

            <div class="relative -left-6 sm:-left-10 max-w-2xl text-right mr-auto pr-2 pb-4 sm:pr-4 sm:pb-6">

                <p class="text-secondary-600
                          font-bold text-sm">

                    لماذا Vivio؟

                </p>

                <h2 class="text-2xl sm:text-3xl
                           font-black leading-relaxed text-primary-950 mt-3">

                    رعاية صحية أبسط وأقرب إليك

                </h2>

                <p class="text-neutral-600
                          text-sm sm:text-base
                          leading-8 mt-4">

                    نساعدك على الوصول إلى معلوماتك الصحية
                    ومتابعة خدماتك الطبية بطريقة سهلة ومنظمة.

                </p>

                <div class="flex flex-wrap gap-x-8 gap-y-3 mt-7">

                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <span class="text-secondary-600 font-black">✓</span>
                        سهولة الاستخدام
                    </div>

                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <span class="text-secondary-600 font-black">✓</span>
                        تنظيم أفضل
                    </div>

                    <div class="flex items-center gap-2 text-sm text-neutral-600">
                        <span class="text-secondary-600 font-black">✓</span>
                        تجربة آمنة
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ================= FOOTER CTA ================= --}}
    <section class="max-w-6xl mx-auto px-6 pb-0 -mt-4">

        <div class="rounded-2xl bg-primary-900
                    px-7 py-1
                    flex flex-col sm:flex-row
                    items-center justify-between gap-3">

            <div class="text-right">

                <h2 class="text-xl font-black text-white">
                    أهلاً بك في Vivio
                </h2>

                <p class="text-white/70 text-sm mt-1">
                    رعاية أسهل، وتنظيم أفضل.
                </p>

            </div>

            <a href="{{ route('profile.edit') }}"
               class="px-6 py-3 rounded-xl
                      bg-secondary-600 text-white
                      text-sm font-bold
                      hover:bg-secondary-700 transition">

                الدخول إلى حسابي ←

            </a>

        </div>

    </section>

</x-app-layout>