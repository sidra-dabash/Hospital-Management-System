<x-app-layout>

    @section('hero-section')

        {{-- ===================================================== --}}
        {{-- هيدر نتائج التقرير --}}
        {{-- ===================================================== --}}

        <section
            class="relative overflow-hidden"
            style="
                width: 100%;
                min-height: 320px;
                background-image: url('{{ asset('images/nav.png') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            "
        >

            <div
                class="relative w-full"
                style="min-height: 320px;"
                dir="rtl"
            >

                {{-- محتوى الهيدر على اليمين --}}
                <div
                    class="absolute"
                    style="
                        right: 6%;
                        top: 50%;
                        transform: translateY(-50%);
                        text-align: right;
                        z-index: 10;
                    "
                >

                    {{-- مسار الصفحة --}}
                    <div class="flex items-center justify-start mb-5">

                        <div class="flex items-center gap-2 bg-white rounded-full shadow-soft px-4 py-2">

                            <a
                                href="{{ route('reports.index') }}"
                                class="text-neutral-500 hover:text-primary-700 text-sm"
                            >
                                التقارير
                            </a>

                            <svg
                                class="w-4 h-4 text-neutral-400 rotate-180"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>

                            <span class="text-primary-700 font-semibold text-sm">
                                نتائج التقرير
                            </span>

                        </div>

                    </div>


                    {{-- عنوان التقرير --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm"
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
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>

                        </div>


                        <div>

                            <h1 class="text-4xl lg:text-5xl font-extrabold text-neutral-800">
                                {{ $reportTitle }}
                            </h1>

                            <p class="text-neutral-700 mt-3 text-lg">

                                من

                                <span class="font-bold">
                                    {{ $dateFrom }}
                                </span>

                                إلى

                                <span class="font-bold">
                                    {{ $dateTo }}
                                </span>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endsection



    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
        dir="rtl"
    >


        {{-- ===================================================== --}}
        {{-- أزرار التحكم --}}
        {{-- ===================================================== --}}

        <div class="flex items-center justify-between gap-4 mb-8">

            {{-- العودة إلى التقارير - يمين --}}

            <a
                href="{{ route('reports.index') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-neutral-200 bg-white text-neutral-700 font-semibold hover:bg-neutral-50 transition"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                العودة إلى التقارير

            </a>


            {{-- تصدير PDF - يسار --}}

            <a
                href="{{ route('reports.export.pdf', [
                    'type' => $reportType,
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo
                ]) }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition"
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
                        d="M12 10v6m0 0l-3-3m3 3l3-3M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                    />
                </svg>

                تصدير PDF

            </a>

        </div>



        {{-- ===================================================== --}}
        {{-- ملخص التقرير --}}
        {{-- ===================================================== --}}

        <div class="card p-6 mb-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">

                <div>

                    <div class="text-sm text-neutral-500 mb-1">
                        التقرير الحالي
                    </div>

                    <div class="text-xl font-extrabold text-neutral-800">
                        {{ $reportTitle }}
                    </div>

                </div>


                <div class="flex flex-wrap gap-6">

                    <div>

                        <div class="text-xs text-neutral-500 mb-1">
                            من تاريخ
                        </div>

                        <div class="font-bold text-neutral-800">
                            {{ $dateFrom }}
                        </div>

                    </div>


                    <div>

                        <div class="text-xs text-neutral-500 mb-1">
                            إلى تاريخ
                        </div>

                        <div class="font-bold text-neutral-800">
                            {{ $dateTo }}
                        </div>

                    </div>


                    <div>

                        <div class="text-xs text-neutral-500 mb-1">
                            عدد النتائج
                        </div>

                        <div class="font-extrabold text-primary-700">
                            {{ number_format($totalResults) }}
                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- بطاقات الإحصائيات --}}
        {{-- ===================================================== --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 mb-8">

            @foreach($summaryStats as $stat)

                <div class="card p-5">

                    <div class="flex items-start justify-between gap-3">

                        <div>

                            <div class="text-sm font-semibold text-neutral-500 mb-2">
                                {{ $stat['label'] }}
                            </div>

                            <div class="text-2xl font-extrabold text-neutral-800">
                                {{ $stat['value'] }}
                            </div>

                            <div class="text-xs text-neutral-500 mt-2">
                                {{ $stat['sub'] }}
                            </div>

                        </div>


                        <div
                            class="w-11 h-11 rounded-xl flex items-center justify-center
                            @if($stat['color'] === 'red')
                                bg-red-50 text-red-600
                            @elseif($stat['color'] === 'secondary')
                                bg-secondary-50 text-secondary-600
                            @elseif($stat['color'] === 'purple')
                                bg-purple-50 text-purple-600
                            @elseif($stat['color'] === 'orange')
                                bg-orange-50 text-orange-600
                            @else
                                bg-primary-50 text-primary-600
                            @endif"
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
                                    d="M9 17v-2m3 2v-4m3 4v-6M5 21h14"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>



        {{-- ===================================================== --}}
        {{-- الرسم البياني --}}
        {{-- ===================================================== --}}

        <div class="card p-6 mb-8">

            <div class="mb-6">

                <h3 class="text-xl font-bold text-neutral-800">
                    توزيع النتائج خلال الفترة
                </h3>

                <p class="text-sm text-neutral-500 mt-1">
                    البيانات مأخوذة من السجلات الموجودة في قاعدة البيانات
                </p>

            </div>


            @php

                /*
                |--------------------------------------------------------------------------
                | مقياس الرسم البياني الديناميكي
                |--------------------------------------------------------------------------
                |
                | نبحث عن أكبر قيمة موجودة في الفترة المختارة.
                |
                | إذا كانت أكبر قيمة 30 أو أقل:
                | يبقى سقف الرسم = 30.
                |
                | إذا تجاوزت أكبر قيمة 30:
                | يرتفع السقف تلقائياً إلى أقرب عشرة.
                |
                | أمثلة:
                |
                | أكبر قيمة = 4   => السقف 30
                | أكبر قيمة = 15  => السقف 30
                | أكبر قيمة = 30  => السقف 30
                | أكبر قيمة = 37  => السقف 40
                | أكبر قيمة = 50  => السقف 50
                | أكبر قيمة = 53  => السقف 60
                | أكبر قيمة = 97  => السقف 100
                | أكبر قيمة = 101 => السقف 110
                |
                */

                $highestResultCount = collect($dailyChart)->max('value') ?? 0;

                if ($highestResultCount <= 30) {

                    $resultsChartMaximum = 30;

                } else {

                    $resultsChartMaximum = (int) (ceil($highestResultCount / 10) * 10);

                }

            @endphp


            @if(count($dailyChart) > 0)

                <div
                    style="
                        width: 100%;
                        overflow-x: auto;
                        overflow-y: hidden;
                    "
                >

                    <div
                        style="
                            display: flex;
                            align-items: flex-end;
                            justify-content: space-between;
                            gap: 14px;
                            height: 260px;
                            min-width: max-content;
                            padding-left: 8px;
                            padding-right: 8px;
                        "
                    >

                        @foreach($dailyChart as $point)

                            @php

                                /*
                                 * العدد الحقيقي في هذا اليوم
                                 */
                                $resultCount = (int) $point['value'];


                                /*
                                 * نحسب النسبة من السقف الديناميكي.
                                 */
                                $percentage = $resultCount > 0
                                    ? min(
                                        ($resultCount / $resultsChartMaximum) * 100,
                                        100
                                    )
                                    : 0;


                                /*
                                 * ارتفاع منطقة العمود = 180px.
                                 *
                                 * أعلى قيمة في المقياس تصل إلى 180px.
                                 *
                                 * وإذا كانت القيمة أكبر من صفر
                                 * نعطيها 8px على الأقل حتى تبقى ظاهرة.
                                 */
                                $barHeight = $resultCount > 0
                                    ? max(
                                        ($percentage / 100) * 180,
                                        8
                                    )
                                    : 0;

                            @endphp


                            <div
                                style="
                                    width: 58px;
                                    flex-shrink: 0;
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
                                        min-height: 18px;
                                    "
                                >
                                    {{ $resultCount }}
                                </div>


                                {{-- خلفية العمود --}}

                                <div
                                    style="
                                        width: 38px;
                                        height: 180px;
                                        background-color: #f1f5f9;
                                        border-radius: 10px 10px 0 0;
                                        position: relative;
                                        overflow: hidden;
                                        flex-shrink: 0;
                                    "
                                >

                                    {{-- الجزء الملون --}}

                                    @if($resultCount > 0)

                                        <div
                                            style="
                                                position: absolute;
                                                bottom: 0;
                                                left: 0;
                                                right: 0;
                                                height: {{ $barHeight }}px;
                                                background: linear-gradient(
                                                    to top,
                                                    #1976a8,
                                                    #49a97b
                                                );
                                                border-radius: 10px 10px 0 0;
                                                transition: height 0.5s ease;
                                            "
                                        >
                                        </div>

                                    @endif

                                </div>


                                {{-- التاريخ --}}

                                <div
                                    style="
                                        font-size: 12px;
                                        color: #64748b;
                                        margin-top: 12px;
                                        white-space: nowrap;
                                    "
                                >
                                    {{ \Carbon\Carbon::parse($point['day'])->format('m-d') }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @else

                <div
                    style="
                        height: 220px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #94a3b8;
                        font-size: 14px;
                    "
                >
                    لا توجد بيانات لعرضها في الرسم البياني
                </div>

            @endif

        </div>



        {{-- ===================================================== --}}
        {{-- جدول النتائج --}}
        {{-- ===================================================== --}}

        <div class="card mt-6 overflow-hidden">

            <div class="p-6 border-b border-neutral-100">

                <h3 class="text-xl font-bold text-neutral-800">
                    تفاصيل النتائج
                </h3>

                <p class="text-sm text-neutral-500 mt-1">
                    {{ number_format($totalResults) }} نتيجة ضمن الفترة المحددة
                </p>

            </div>


            @if($results->count() > 0)

                <div class="overflow-x-auto pt-5">

                    <table class="w-full">


                        {{-- ================================================= --}}
                        {{-- تقرير المرضى --}}
                        {{-- ================================================= --}}

                        @if($reportType === 'patients')

                            <thead class="bg-neutral-50">

                                <tr>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        #
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        اسم المريض
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الجنس
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ الميلاد
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        فصيلة الدم
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الهاتف
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ التسجيل
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-neutral-100">

                                @foreach($results as $patient)

                                    <tr class="table-row-hover">

                                        <td class="px-5 py-4 text-sm text-neutral-500">
                                            {{ $patient->id }}
                                        </td>

                                        <td class="px-5 py-4 font-bold text-neutral-800">
                                            {{ $patient->full_name }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">

                                            @if($patient->gender === 'male')

                                                ذكر

                                            @elseif($patient->gender === 'female')

                                                أنثى

                                            @else

                                                {{ $patient->gender ?? '—' }}

                                            @endif

                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $patient->birth_date?->format('Y-m-d') ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $patient->blood_type ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $patient->phone ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $patient->created_at?->format('Y-m-d') ?? '—' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>



                        {{-- ================================================= --}}
                        {{-- تقرير المواعيد --}}
                        {{-- ================================================= --}}

                        @elseif($reportType === 'appointments')

                            <thead class="bg-neutral-50">

                                <tr>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        #
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        المريض
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الطبيب
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        القسم
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ الموعد
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الحالة
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        ملاحظات
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-neutral-100">

                                @foreach($results as $appointment)

                                    <tr class="table-row-hover">

                                        <td class="px-5 py-4 text-sm text-neutral-500">
                                            {{ $appointment->id }}
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-neutral-800">
                                            {{ $appointment->patient?->full_name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-700">
                                            {{ $appointment->doctor?->user?->name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $appointment->doctor?->department?->name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $appointment->appointment_date?->format('Y-m-d H:i') ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4">

                                            @if($appointment->status === 'completed')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                                    مكتمل
                                                </span>

                                            @elseif($appointment->status === 'confirmed')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                                    مؤكد
                                                </span>

                                            @elseif($appointment->status === 'cancelled')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                                                    ملغي
                                                </span>

                                            @elseif($appointment->status === 'pending')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700">
                                                    قيد الانتظار
                                                </span>

                                            @else

                                                <span class="text-sm text-neutral-500">
                                                    {{ $appointment->status ?? '—' }}
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600 max-w-xs">
                                            {{ $appointment->notes ?? '—' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>



                        {{-- ================================================= --}}
                        {{-- تقرير السجلات الطبية --}}
                        {{-- ================================================= --}}

                        @elseif($reportType === 'medical_records')

                            <thead class="bg-neutral-50">

                                <tr>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        #
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        المريض
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الطبيب
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        القسم
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ الزيارة
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        التشخيص
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        العلاج
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الوصفة
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-neutral-100">

                                @foreach($results as $record)

                                    <tr class="table-row-hover">

                                        <td class="px-5 py-4 text-sm text-neutral-500">
                                            {{ $record->id }}
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-neutral-800">
                                            {{ $record->patient?->full_name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-700">
                                            {{ $record->doctor?->user?->name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $record->doctor?->department?->name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $record->visit_date?->format('Y-m-d H:i') ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600 max-w-xs">
                                            {{ $record->diagnosis ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600 max-w-xs">
                                            {{ $record->treatment ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600 max-w-xs">
                                            {{ $record->prescription ?? '—' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>



                        {{-- ================================================= --}}
                        {{-- تقرير الفواتير --}}
                        {{-- ================================================= --}}

                        @elseif($reportType === 'bills')

                            <thead class="bg-neutral-50">

                                <tr>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        #
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        المريض
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        المبلغ
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        الحالة
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ الإصدار
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        تاريخ الاستحقاق
                                    </th>

                                    <th class="px-5 py-4 text-right text-sm font-bold text-neutral-700">
                                        ملاحظات
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-neutral-100">

                                @foreach($results as $bill)

                                    <tr class="table-row-hover">

                                        <td class="px-5 py-4 text-sm text-neutral-500">
                                            {{ $bill->id }}
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-neutral-800">
                                            {{ $bill->patient?->full_name ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 font-bold text-neutral-800">
                                            {{ number_format((float) $bill->amount, 2) }}
                                        </td>

                                        <td class="px-5 py-4">

                                            @if($bill->status === 'paid')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                                    مدفوعة
                                                </span>

                                            @elseif($bill->status === 'unpaid')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                                                    غير مدفوعة
                                                </span>

                                            @elseif($bill->status === 'partial')

                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700">
                                                    مدفوعة جزئياً
                                                </span>

                                            @else

                                                <span class="text-sm text-neutral-500">
                                                    {{ $bill->status ?? '—' }}
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $bill->issue_date?->format('Y-m-d') ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600">
                                            {{ $bill->due_date?->format('Y-m-d') ?? '—' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-neutral-600 max-w-xs">
                                            {{ $bill->notes ?? '—' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        @endif

                    </table>

                </div>



                {{-- ===================================================== --}}
                {{-- Pagination --}}
                {{-- ===================================================== --}}

                @if($results->hasPages())

                    <div class="p-6 border-t border-neutral-100">
                        {{ $results->links() }}
                    </div>

                @endif



            @else


                {{-- ===================================================== --}}
                {{-- لا توجد نتائج --}}
                {{-- ===================================================== --}}

                <div class="py-16 px-6 text-center">

                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-100 flex items-center justify-center">

                        <svg
                            class="w-8 h-8 text-neutral-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </div>


                    <h3 class="text-lg font-bold text-neutral-700">
                        لا توجد نتائج
                    </h3>


                    <p class="text-sm text-neutral-500 mt-2">
                        لا توجد بيانات مسجلة لهذا التقرير ضمن الفترة الزمنية المحددة.
                    </p>


                    <a
                        href="{{ route('reports.index') }}"
                        class="inline-flex mt-5 text-primary-700 font-bold hover:underline"
                    >
                        اختيار فترة أخرى
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
