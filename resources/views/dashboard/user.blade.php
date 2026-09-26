<x-app-layout>

    <style>
        .doctor-hero {
            position: relative;
            overflow: hidden;
            width: 100%;
            background: linear-gradient(110deg, #eef8ff 0%, #ffffff 48%, #f0faf5 100%);
        }

        .doctor-hero-inner {
            min-height: 310px;
            display: grid;
            width: min(1280px, calc(100% - 48px));
            margin: 0 auto;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            align-items: center;
            gap: 28px;
            padding: 48px 0;
            direction: ltr;
        }

        .doctor-hero-content {
            text-align: right;
            order: 2;
            direction: rtl;
        }

        .doctor-hero-title {
            margin: 16px 0 0;
            color: #123b63;
            font-size: 42px;
            line-height: 1.25;
            font-weight: 900;
        }

        .doctor-hero-image-wrap {
            position: relative;
            min-height: 320px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            order: 1;
        }

        .doctor-hero-image {
            display: block;
            width: 100%;
            max-width: 560px;
            max-height: 360px;
            object-fit: contain;
            object-position: left center;
        }

        @media (max-width: 1100px) {
            .doctor-hero-inner {
                width: min(calc(100% - 32px), 900px);
                grid-template-columns: 1fr;
            }

            .doctor-hero-content {
                order: 1;
            }

            .doctor-hero-image-wrap {
                justify-content: center;
                order: 2;
            }
        }

        @media (max-width: 760px) {
            .doctor-hero-inner {
                width: calc(100% - 24px);
                min-height: auto;
                gap: 24px;
                padding: 26px 20px;
            }

            .doctor-hero-title {
                font-size: 32px;
            }

            .doctor-hero-image-wrap {
                min-height: 180px;
            }

            .doctor-hero-image {
                max-height: 260px;
                object-position: center;
            }
        }
    </style>

    {{-- ================= HERO ================= --}}
    <section class="doctor-hero">

        <div class="doctor-hero-inner">

            <div class="doctor-hero-content">

                <div>
                    <p class="text-secondary-600 font-bold text-base mb-3">
                        أهلاً بك في Vivio
                    </p>

                    <h1 class="doctor-hero-title">

                        صحتك أولويتنا
                        <span class="block text-secondary-600 mt-2">
                            ورعايتك أسهل معنا
                        </span>

                    </h1>

                    <p class="text-primary-800 text-base sm:text-lg
                              leading-8 mt-7">

                        منصة صحية تساعدك على الوصول إلى خدمات المشفى
                        ومتابعة رحلتك العلاجية بسهولة وأمان.

                    </p>
                </div>

            </div>

            <div class="doctor-hero-image-wrap">
                <img
                    src="{{ asset('images/image-transparent.png') }}"
                    alt="لوحة متابعة الرعاية الصحية والطبية"
                    class="doctor-hero-image"
                    loading="lazy"
                >
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
            <div
                      class="h-full bg-white rounded-2xl
                      border border-neutral-100
                      p-6 text-center
                      shadow-sm">

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

                <a href="{{ route('patients.index') }}" class="inline-block
                             text-secondary-600
                             text-sm font-bold mt-4">

                    عرض المرضى ←

                </a>

            </div>


            {{-- Appointments --}}
                <div
                    class="h-full bg-white rounded-2xl
                             border border-neutral-100
                             p-6 text-center
                             shadow-sm">

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

                <a href="{{ route('appointments.index') }}" class="inline-block
                             text-secondary-600
                             text-sm font-bold mt-4">

                    عرض المواعيد ←

                </a>

            </div>


                {{-- Personal Profile --}}
                <div
                    class="h-full bg-white rounded-2xl
                             border border-neutral-100
                             p-6 text-center
                             shadow-sm">

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

                <a href="{{ route('profile.edit') }}" class="inline-block text-secondary-600 text-sm font-bold mt-4">

                    عرض الملف الشخصي ←

                </a>

            </div>

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

            
        </div>

    </section>

</x-app-layout>
