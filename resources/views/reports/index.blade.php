<x-app-layout>

    @section('hero-section')

        <section
            class="relative overflow-hidden"
            style="
                width: 100%;
                height: 320px;
                background-image: url('{{ asset('images/nav.png') }}');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
            "
        >

            {{-- ================================================= --}}
            {{-- محتوى الهيرو - أقصى اليمين --}}
            {{-- ================================================= --}}

            <div
                class="absolute inset-0"
                dir="rtl"
            >

                <div
                    style="
                        position: absolute;
                        right: 6%;
                        top: 50%;
                        transform: translateY(-50%);
                        width: 42%;
                        text-align: right;
                    "
                >

                    {{-- مسار الصفحة: الرئيسية > التقارير --}}

                    <div
                        style="
                            display: flex;
                            justify-content: flex-start;
                            align-items: center;
                            margin-bottom: 22px;
                        "
                    >

                        <div
                            style="
                                display: inline-flex;
                                align-items: center;
                                gap: 9px;
                                background: rgba(255, 255, 255, 0.92);
                                padding: 8px 16px;
                                border-radius: 999px;
                                box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
                            "
                        >

                            <span class="text-neutral-500 text-sm">
                                الرئيسية
                            </span>

                            <svg
                                class="w-4 h-4 text-neutral-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>

                            <span class="text-primary-700 font-semibold text-sm">
                                التقارير
                            </span>

                        </div>

                    </div>


                    {{-- عنوان التقارير والأيقونة --}}

                    <div
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: flex-start;
                            gap: 14px;
                            margin-bottom: 14px;
                        "
                    >

                        <div
                            style="
                                width: 56px;
                                height: 56px;
                                flex-shrink: 0;
                                border-radius: 16px;
                                background: rgba(255, 255, 255, 0.80);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
                            "
                        >

                            <svg
                                class="w-8 h-8 text-primary-700"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>

                        </div>


                        <h1
                            style="
                                margin: 0;
                                font-size: 46px;
                                line-height: 1.2;
                                font-weight: 800;
                                color: #172033;
                            "
                        >
                            التقارير
                        </h1>

                    </div>


                    {{-- وصف الصفحة --}}

                    <p
                        style="
                            margin: 0;
                            font-size: 18px;
                            line-height: 1.8;
                            color: #475569;
                            font-weight: 500;
                            text-align: right;
                        "
                    >
                        متابعة شاملة لبيانات النظام وإنشاء التقارير الإدارية
                    </p>

                </div>

            </div>

        </section>

    @endsection



    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
        dir="rtl"
    >


        {{-- ================================================= --}}
        {{-- رسائل الأخطاء --}}
        {{-- ================================================= --}}

        @if ($errors->any())

            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5">

                <div class="font-bold text-red-700 mb-2">
                    يرجى التأكد من بيانات التقرير:
                </div>

                <ul class="text-sm text-red-600 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>• {{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ================================================= --}}
        {{-- بطاقات الإحصائيات --}}
        {{-- ================================================= --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            @foreach($stats as $stat)

                <div class="card p-6 transition hover:-translate-y-1">

                    <div class="flex items-start justify-between gap-4">

                        <div>

                            <div class="text-sm font-semibold text-neutral-500 mb-2">
                                {{ $stat['label'] }}
                            </div>

                            <div class="text-3xl font-extrabold text-neutral-800">
                                {{ number_format($stat['value']) }}
                            </div>

                            <div class="text-xs text-neutral-500 mt-2">
                                {{ $stat['sub'] }}
                            </div>

                        </div>


                        <div class="w-12 h-12 rounded-2xl
                            @if($stat['color'] === 'red')
                                bg-red-50 text-red-600
                            @elseif($stat['color'] === 'secondary')
                                bg-secondary-50 text-secondary-600
                            @elseif($stat['color'] === 'purple')
                                bg-purple-50 text-purple-600
                            @else
                                bg-primary-50 text-primary-600
                            @endif
                            flex items-center justify-center">

                            @if($stat['icon'] === 'users')

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>

                            @elseif($stat['icon'] === 'calendar-check')

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 11l3 3L22 4M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                    />
                                </svg>

                            @elseif($stat['icon'] === 'calendar-x')

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                            @else

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>



        {{-- ================================================= --}}
        {{-- الرسوم والإحصائيات --}}
        {{-- ================================================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">


            {{-- ================================================= --}}
            {{-- تسجيل المرضى خلال آخر 7 أيام --}}
            {{-- ================================================= --}}

            <div class="card p-6 lg:col-span-2">

                <div class="flex items-center justify-between mb-6">

                    <div>

                        <h3 class="font-bold text-xl text-neutral-800">
                            تسجيل المرضى
                        </h3>

                        <p class="text-sm text-neutral-500 mt-1">
                            عدد المرضى المسجلين خلال آخر 7 أيام
                        </p>

                    </div>


                    <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center">

                        <svg
                            class="w-6 h-6 text-primary-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3v18h18M7 16l4-4 3 3 5-7"
                            />
                        </svg>

                    </div>

                </div>


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | مقياس الرسم البياني الديناميكي
                    |--------------------------------------------------------------------------
                    |
                    | نبحث عن أكبر عدد مرضى موجود في الأيام السبعة.
                    |
                    | إذا كان أكبر عدد 30 أو أقل:
                    | يبقى سقف الرسم = 30.
                    |
                    | إذا تجاوز العدد 30:
                    | يرتفع السقف تلقائياً إلى أقرب عشرة.
                    |
                    | أمثلة:
                    |
                    | أكبر عدد = 4   => السقف 30
                    | أكبر عدد = 20  => السقف 30
                    | أكبر عدد = 30  => السقف 30
                    | أكبر عدد = 37  => السقف 40
                    | أكبر عدد = 50  => السقف 50
                    | أكبر عدد = 53  => السقف 60
                    | أكبر عدد = 97  => السقف 100
                    |
                    */

                    $highestPatientsCount = collect($chartWeek)->max('patients') ?? 0;

                    if ($highestPatientsCount <= 30) {

                        $patientsChartMaximum = 30;

                    } else {

                        $patientsChartMaximum = (int) (ceil($highestPatientsCount / 10) * 10);

                    }

                @endphp


                <div
                    style="
                        display: flex;
                        align-items: flex-end;
                        justify-content: space-between;
                        gap: 12px;
                        height: 260px;
                    "
                >

                    @foreach($chartWeek as $day)

                        @php

                            /*
                             * العدد الحقيقي للمرضى في هذا اليوم
                             */
                            $patientsCount = (int) $day['patients'];


                            /*
                             * نحسب نسبة هذا العدد من السقف الديناميكي.
                             */
                            $percentage = $patientsCount > 0
                                ? min(
                                    ($patientsCount / $patientsChartMaximum) * 100,
                                    100
                                )
                                : 0;


                            /*
                             * ارتفاع منطقة الرسم الفعلية = 180px.
                             *
                             * أعلى قيمة في المقياس ستأخذ 180px كاملة.
                             *
                             * نضع 8px كحد أدنى للعدد الأكبر من صفر
                             * حتى يبقى العمود الصغير واضحاً.
                             */
                            $barHeight = $patientsCount > 0
                                ? max(
                                    ($percentage / 100) * 180,
                                    8
                                )
                                : 0;

                        @endphp


                        <div
                            style="
                                flex: 1;
                                height: 100%;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: flex-end;
                            "
                        >

                            {{-- الرقم الحقيقي --}}

                            <div
                                style="
                                    font-size: 12px;
                                    font-weight: 700;
                                    color: #0369a1;
                                    margin-bottom: 8px;
                                "
                            >
                                {{ $patientsCount }}
                            </div>


                            {{-- منطقة العمود --}}

                            <div
                                style="
                                    width: 38px;
                                    height: 180px;
                                    background-color: #f1f5f9;
                                    border-radius: 10px 10px 0 0;
                                    position: relative;
                                    overflow: hidden;
                                "
                            >

                                {{-- الجزء الملون --}}

                                @if($patientsCount > 0)

                                    <div
                                        style="
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            right: 0;
                                            height: {{ $barHeight }}px;
                                            background: linear-gradient(to top, #1976a8, #49a97b);
                                            border-radius: 10px 10px 0 0;
                                            transition: height 0.5s ease;
                                        "
                                    ></div>

                                @endif

                            </div>


                            {{-- اسم اليوم --}}

                            <div
                                style="
                                    font-size: 12px;
                                    color: #64748b;
                                    margin-top: 12px;
                                    white-space: nowrap;
                                "
                            >
                                {{ $day['day'] }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- حالات المواعيد --}}
            {{-- ================================================= --}}

            <div class="card p-6">

                <div class="mb-6">

                    <h3 class="font-bold text-xl text-neutral-800">
                        حالات المواعيد
                    </h3>

                    <p class="text-sm text-neutral-500 mt-1">
                        التوزيع الحالي لجميع المواعيد
                    </p>

                </div>


                <div class="space-y-5">

                    @foreach($appointmentsStatus as $status)

                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <div class="flex items-center gap-2">

                                    <span class="w-3 h-3 rounded-full
                                        @if($status['color'] === 'red')
                                            bg-red-500
                                        @elseif($status['color'] === 'secondary')
                                            bg-secondary-500
                                        @elseif($status['color'] === 'purple')
                                            bg-purple-500
                                        @else
                                            bg-primary-500
                                        @endif">
                                    </span>

                                    <span class="text-sm font-semibold text-neutral-700">
                                        {{ $status['label'] }}
                                    </span>

                                </div>


                                <div class="text-left">

                                    <span class="font-bold text-neutral-800">
                                        {{ $status['count'] }}
                                    </span>

                                    <span class="text-xs text-neutral-400 mr-1">
                                        {{ $status['percent'] }}%
                                    </span>

                                </div>

                            </div>


                            <div class="w-full h-2.5 bg-neutral-100 rounded-full overflow-hidden">

                                <div
                                    class="h-full rounded-full
                                        @if($status['color'] === 'red')
                                            bg-red-500
                                        @elseif($status['color'] === 'secondary')
                                            bg-secondary-500
                                        @elseif($status['color'] === 'purple')
                                            bg-purple-500
                                        @else
                                            bg-primary-500
                                        @endif"
                                    style="width: {{ $status['percent'] }}%"
                                ></div>

                            </div>

                        </div>

                    @endforeach


                    <div class="border-t border-neutral-100 pt-4 mt-5">

                        <div class="flex items-center justify-between">

                            <span class="text-sm text-neutral-500">
                                إجمالي المواعيد
                            </span>

                            <span class="text-xl font-extrabold text-neutral-800">
                                {{ number_format($totalAppointments) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- أنواع التقارير + إعداد التقرير --}}
        {{-- ================================================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- ================================================= --}}
            {{-- أنواع التقارير --}}
            {{-- ================================================= --}}

            <div class="card lg:col-span-2 overflow-hidden">

                <div class="p-6 border-b border-neutral-100">

                    <h3 class="font-bold text-xl text-neutral-800">
                        أنواع التقارير
                    </h3>

                    <p class="text-sm text-neutral-500 mt-1">
                        اختر التقرير الذي تريد استعراضه
                    </p>

                </div>


                <div class="overflow-x-auto pt-5">

                    <table class="w-full">

                        <thead class="bg-neutral-50/70">

                            <tr>

                                <th class="px-6 py-4 text-right text-sm font-bold text-neutral-700">
                                    نوع التقرير
                                </th>

                                <th class="px-6 py-4 text-right text-sm font-bold text-neutral-700">
                                    المحتوى
                                </th>

                                <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700">
                                    العدد الحالي
                                </th>

                                <th class="px-6 py-4 text-center text-sm font-bold text-neutral-700">
                                    العملية
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-neutral-100">

                            @foreach($reportTypes as $report)

                                <tr class="table-row-hover">

                                    <td class="px-6 py-5">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">

                                                <svg
                                                    class="w-5 h-5 text-primary-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                                    />
                                                </svg>

                                            </div>


                                            <span class="font-bold text-neutral-800">
                                                {{ $report['type'] }}
                                            </span>

                                        </div>

                                    </td>


                                    <td class="px-6 py-5 text-sm text-neutral-600">
                                        {{ $report['subject'] }}
                                    </td>


                                    <td class="px-6 py-5 text-center">

                                        <span class="inline-flex items-center justify-center min-w-12 px-3 py-1.5 rounded-xl bg-neutral-100 font-bold text-neutral-700">
                                            {{ number_format($report['count']) }}
                                        </span>

                                    </td>


                                    <td class="px-6 py-5 text-center">

                                        <a
                                            href="{{ route('reports.results', [
                                                'type' => $report['key'],
                                                'date_from' => now()->startOfMonth()->format('Y-m-d'),
                                                'date_to' => now()->format('Y-m-d')
                                            ]) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-primary-200 text-primary-700 hover:bg-primary-50 transition text-sm font-semibold"
                                        >

                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>

                                            عرض

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- إعداد التقرير --}}
            {{-- ================================================= --}}

            <div class="card p-6 h-fit">

                <div class="flex items-center justify-between mb-6">

                    <div>

                        <h3 class="font-bold text-lg text-neutral-800">
                            إعداد التقرير
                        </h3>

                        <p class="text-xs text-neutral-500 mt-1">
                            اختر النوع والفترة الزمنية
                        </p>

                    </div>


                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">

                        <svg
                            class="w-5 h-5 text-primary-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                            />
                        </svg>

                    </div>

                </div>


                <form
                    method="GET"
                    action="{{ route('reports.results') }}"
                    class="space-y-5"
                >

                    {{-- نوع التقرير --}}

                    <div>

                        <label
                            for="type"
                            class="block text-sm font-bold text-neutral-700 mb-2"
                        >
                            نوع التقرير
                        </label>


                        <select
                            id="type"
                            name="type"
                            required
                            class="select-field w-full"
                        >

                            <option value="">
                                اختر نوع التقرير
                            </option>

                            @foreach($reportTypes as $report)

                                <option
                                    value="{{ $report['key'] }}"
                                    {{ old('type') === $report['key'] ? 'selected' : '' }}
                                >
                                    {{ $report['type'] }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- من تاريخ --}}

                    <div>

                        <label
                            for="date_from"
                            class="block text-sm font-bold text-neutral-700 mb-2"
                        >
                            من تاريخ
                        </label>

                        <input
                            id="date_from"
                            type="date"
                            name="date_from"
                            value="{{ old('date_from', now()->startOfMonth()->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}"
                            required
                            class="input-field w-full"
                        >

                    </div>


                    {{-- إلى تاريخ --}}

                    <div>

                        <label
                            for="date_to"
                            class="block text-sm font-bold text-neutral-700 mb-2"
                        >
                            إلى تاريخ
                        </label>

                        <input
                            id="date_to"
                            type="date"
                            name="date_to"
                            value="{{ old('date_to', now()->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}"
                            required
                            class="input-field w-full"
                        >

                    </div>


                    {{-- زر عرض النتائج --}}

                    <button
                        type="submit"
                        class="btn-blue w-full inline-flex items-center justify-center gap-2"
                    >

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>

                        عرض النتائج

                    </button>

                </form>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- حول التقارير --}}
        {{-- ================================================= --}}

        <div class="mt-8 card p-6 border-r-4 border-r-secondary-500">

            <div class="flex items-start gap-4">

                <div class="w-11 h-11 flex-shrink-0 rounded-xl bg-secondary-50 flex items-center justify-center">

                    <svg
                        class="w-6 h-6 text-secondary-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                </div>


                <div>

                    <h3 class="font-bold text-neutral-800 mb-1">
                        حول التقارير
                    </h3>

                    <p class="text-sm text-neutral-600 leading-7">
                        تعتمد الإحصائيات والتقارير المعروضة في هذه الصفحة
                        على البيانات المسجلة فعلياً في النظام.
                        اختر نوع التقرير والفترة الزمنية ثم اضغط
                        «عرض النتائج» للاطلاع على التفاصيل.
                    </p>

                </div>

            </div>

        </div>


    </div>

</x-app-layout>
