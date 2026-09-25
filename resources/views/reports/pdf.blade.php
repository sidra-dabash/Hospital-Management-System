<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">

    <title>{{ $reportTitle }} - Vivio</title>

    <style>
        @page {
            margin: 25px 28px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            text-align: right;
            font-family: DejaVu Sans, sans-serif;
            color: #263238;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* ========================================= */
        /* رأس التقرير */
        /* ========================================= */

        .header {
            width: 100%;
            border-bottom: 3px solid #1976a8;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo-cell {
            width: 30%;
            text-align: left;
        }

        .title-cell {
            width: 70%;
            text-align: right;
        }

        /*
        |--------------------------------------------------------------------------
        | شعار Vivio الحقيقي
        |--------------------------------------------------------------------------
        */

        .logo-image {
            width: 190px;
            height: auto;
            display: block;
            margin-left: 0;
        }

        .system-name {
            color: #1976a8;
            font-size: 12px;
            margin-bottom: 5px;
        }

        h1 {
            margin: 0;
            color: #263238;
            font-size: 22px;
        }

        .subtitle {
            color: #66757f;
            margin-top: 7px;
            font-size: 10px;
        }

        /* ========================================= */
        /* معلومات التقرير */
        /* ========================================= */

        .info-box {
            width: 100%;
            background-color: #f4f9fb;
            border: 1px solid #d8e8ef;
            padding: 11px 8px;
            margin-bottom: 17px;
        }

        /*
         * كل عنوان وقيمته موجودان بخليتين منفصلتين
         * للحفاظ على الترتيب الصحيح داخل DomPDF.
         */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            direction: ltr;
            table-layout: fixed;
        }

        .info-table td {
            border: none;
            padding: 3px 2px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .info-value-cell {
            color: #52636d;
            font-weight: normal;
            text-align: right;
            direction: ltr;
        }

        .info-label-cell {
            color: #1976a8;
            font-weight: bold;
            text-align: left;
            direction: ltr;
        }

        .info-value-small {
            width: 11%;
        }

        .info-label-small {
            width: 14%;
        }

        .info-value-date {
            width: 16%;
        }

        .info-label-date {
            width: 19%;
        }

        /* ========================================= */
        /* الإحصائيات */
        /* ========================================= */

        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin-bottom: 18px;
        }

        .stats-table td {
            background-color: #f7fbfc;
            border: 1px solid #dcebf0;
            padding: 10px;
            text-align: center;
        }

        .stat-label {
            color: #60747e;
            font-size: 9px;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #1976a8;
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            color: #263238;
            font-weight: bold;
            margin: 15px 0 8px;
            padding-right: 8px;
            border-right: 4px solid #49a97b;
            text-align: right;
        }

        /* ========================================= */
        /* جدول البيانات */
        /* ========================================= */

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .data-table thead {
            display: table-header-group;
        }

        .data-table th {
            background-color: #1976a8;
            color: white;
            font-size: 9px;
            font-weight: bold;
            padding: 8px 5px;
            text-align: center;
            border: 1px solid #15658f;
        }

        .data-table td {
            padding: 7px 5px;
            border: 1px solid #dce4e8;
            text-align: center;
            vertical-align: middle;
            font-size: 8.5px;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fbfc;
        }

        .status {
            font-weight: bold;
        }

        .status-completed,
        .status-paid {
            color: #27875a;
        }

        .status-cancelled,
        .status-unpaid {
            color: #c34242;
        }

        .status-confirmed {
            color: #1976a8;
        }

        .status-pending,
        .status-partial {
            color: #c17a20;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #778892;
            background-color: #f8fafb;
            border: 1px solid #e1e8eb;
        }

        /* ========================================= */
        /* أسفل التقرير */
        /* ========================================= */

        .footer {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #dce4e8;
            color: #7b8a92;
            font-size: 8px;
            text-align: center;
        }

        .footer-brand {
            color: #1976a8;
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        /*
        |--------------------------------------------------------------------------
        | معالجة النص العربي للـ PDF
        |--------------------------------------------------------------------------
        */

        $Arabic = new \ArPHP\I18N\Arabic();

        $ar = function ($text) use ($Arabic) {

            if ($text === null || $text === '') {
                return '—';
            }

            return $Arabic->utf8Glyphs(
                (string) $text,
                100,
                false,
                true
            );
        };
    @endphp


    {{-- ============================================= --}}
    {{-- رأس التقرير --}}
    {{-- ============================================= --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td class="title-cell">

                    <div class="system-name">
                        {{ $ar('نظام Vivio الطبي') }}
                    </div>

                    <h1>
                        {{ $ar($reportTitle) }}
                    </h1>

                    <div class="subtitle">
                        {{ $ar('تقرير إداري صادر من نظام Vivio') }}
                    </div>

                </td>


                <td class="logo-cell">

                    <img
                        src="{{ public_path('images/vivio-logo-pdf.jpg') }}"
                        class="logo-image"
                        alt="Vivio">

                </td>

            </tr>

        </table>

    </div>


    {{-- ============================================= --}}
    {{-- معلومات التقرير --}}
    {{-- ============================================= --}}

    <div class="info-box">

        <table class="info-table">

            <tr>

                {{-- الفترة من --}}
                <td class="info-value-cell info-value-small">
                    {{ $dateFrom }}
                </td>

                <td class="info-label-cell info-label-small">
                    {{ $ar('الفترة من:') }}
                </td>


                {{-- الفترة إلى --}}
                <td class="info-value-cell info-value-small">
                    {{ $dateTo }}
                </td>

                <td class="info-label-cell info-label-small">
                    {{ $ar('الفترة إلى:') }}
                </td>


                {{-- عدد النتائج --}}
                <td class="info-value-cell info-value-small">
                    {{ $totalResults }}
                </td>

                <td class="info-label-cell info-label-small">
                    {{ $ar('عدد النتائج:') }}
                </td>


                {{-- تاريخ إنشاء التقرير --}}
                <td class="info-value-cell info-value-date">
                    {{ $generatedAt }}
                </td>

                <td class="info-label-cell info-label-date">
                    {{ $ar('تاريخ إنشاء التقرير:') }}
                </td>

            </tr>

        </table>

    </div>


    {{-- ============================================= --}}
    {{-- ملخص التقرير --}}
    {{-- ============================================= --}}

    @if(count($summaryStats) > 0)

        <div class="section-title">
            {{ $ar('ملخص التقرير') }}
        </div>

        <table class="stats-table">

            <tr>

                @foreach($summaryStats as $stat)

                    <td>

                        <div class="stat-label">
                            {{ $ar($stat['label']) }}
                        </div>

                        <div class="stat-value">
                            {{ $stat['value'] }}
                        </div>

                    </td>

                @endforeach

            </tr>

        </table>

    @endif


    {{-- ============================================= --}}
    {{-- تفاصيل التقرير --}}
    {{-- ============================================= --}}

    <div class="section-title">
        {{ $ar('تفاصيل التقرير') }}
    </div>


    @if($results->count() > 0)


        {{-- ========================================= --}}
        {{-- تقرير المرضى --}}
        {{-- ========================================= --}}

        @if($reportType === 'patients')

            <table class="data-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>
                            {{ $ar('اسم المريض') }}
                        </th>

                        <th>
                            {{ $ar('الجنس') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ الميلاد') }}
                        </th>

                        <th>
                            {{ $ar('فصيلة الدم') }}
                        </th>

                        <th>
                            {{ $ar('رقم الهاتف') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ التسجيل') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($results as $patient)

                        <tr>

                            <td>
                                {{ $patient->id }}
                            </td>


                            <td>
                                {{ $ar($patient->full_name) }}
                            </td>


                            <td>

                                @if($patient->gender === 'male')

                                    {{ $ar('ذكر') }}

                                @elseif($patient->gender === 'female')

                                    {{ $ar('أنثى') }}

                                @else

                                    {{ $ar($patient->gender ?? '—') }}

                                @endif

                            </td>


                            <td>
                                {{ $patient->birth_date?->format('Y-m-d') ?? '—' }}
                            </td>


                            <td>
                                {{ $patient->blood_type ?? '—' }}
                            </td>


                            <td>
                                {{ $patient->phone ?? '—' }}
                            </td>


                            <td>
                                {{ $patient->created_at?->format('Y-m-d') ?? '—' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


        {{-- ========================================= --}}
        {{-- تقرير المواعيد --}}
        {{-- ========================================= --}}

        @elseif($reportType === 'appointments')

            <table class="data-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>
                            {{ $ar('المريض') }}
                        </th>

                        <th>
                            {{ $ar('الطبيب') }}
                        </th>

                        <th>
                            {{ $ar('القسم') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ الموعد') }}
                        </th>

                        <th>
                            {{ $ar('الحالة') }}
                        </th>

                        <th>
                            {{ $ar('ملاحظات') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($results as $appointment)

                        <tr>

                            <td>
                                {{ $appointment->id }}
                            </td>


                            <td>
                                {{ $ar($appointment->patient?->full_name ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($appointment->doctor?->user?->name ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($appointment->doctor?->department?->name ?? '—') }}
                            </td>


                            <td>
                                {{ $appointment->appointment_date?->format('Y-m-d H:i') ?? '—' }}
                            </td>


                            <td>

                                @if($appointment->status === 'completed')

                                    <span class="status status-completed">
                                        {{ $ar('مكتمل') }}
                                    </span>

                                @elseif($appointment->status === 'confirmed')

                                    <span class="status status-confirmed">
                                        {{ $ar('مؤكد') }}
                                    </span>

                                @elseif($appointment->status === 'cancelled')

                                    <span class="status status-cancelled">
                                        {{ $ar('ملغي') }}
                                    </span>

                                @elseif($appointment->status === 'pending')

                                    <span class="status status-pending">
                                        {{ $ar('قيد الانتظار') }}
                                    </span>

                                @else

                                    {{ $ar($appointment->status ?? '—') }}

                                @endif

                            </td>


                            <td>
                                {{ $ar($appointment->notes ?? '—') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


        {{-- ========================================= --}}
        {{-- تقرير السجلات الطبية --}}
        {{-- ========================================= --}}

        @elseif($reportType === 'medical_records')

            <table class="data-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>
                            {{ $ar('المريض') }}
                        </th>

                        <th>
                            {{ $ar('الطبيب') }}
                        </th>

                        <th>
                            {{ $ar('القسم') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ الزيارة') }}
                        </th>

                        <th>
                            {{ $ar('التشخيص') }}
                        </th>

                        <th>
                            {{ $ar('العلاج') }}
                        </th>

                        <th>
                            {{ $ar('الوصفة الطبية') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($results as $record)

                        <tr>

                            <td>
                                {{ $record->id }}
                            </td>


                            <td>
                                {{ $ar($record->patient?->full_name ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($record->doctor?->user?->name ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($record->doctor?->department?->name ?? '—') }}
                            </td>


                            <td>
                                {{ $record->visit_date?->format('Y-m-d H:i') ?? '—' }}
                            </td>


                            <td>
                                {{ $ar($record->diagnosis ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($record->treatment ?? '—') }}
                            </td>


                            <td>
                                {{ $ar($record->prescription ?? '—') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


        {{-- ========================================= --}}
        {{-- تقرير الفواتير --}}
        {{-- ========================================= --}}

        @elseif($reportType === 'bills')

            <table class="data-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>
                            {{ $ar('المريض') }}
                        </th>

                        <th>
                            {{ $ar('المبلغ') }}
                        </th>

                        <th>
                            {{ $ar('الحالة') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ الإصدار') }}
                        </th>

                        <th>
                            {{ $ar('تاريخ الاستحقاق') }}
                        </th>

                        <th>
                            {{ $ar('ملاحظات') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($results as $bill)

                        <tr>

                            <td>
                                {{ $bill->id }}
                            </td>


                            <td>
                                {{ $ar($bill->patient?->full_name ?? '—') }}
                            </td>


                            <td>
                                {{ number_format((float) $bill->amount, 2) }}
                            </td>


                            <td>

                                @if($bill->status === 'paid')

                                    <span class="status status-paid">
                                        {{ $ar('مدفوعة') }}
                                    </span>

                                @elseif($bill->status === 'unpaid')

                                    <span class="status status-unpaid">
                                        {{ $ar('غير مدفوعة') }}
                                    </span>

                                @elseif($bill->status === 'partial')

                                    <span class="status status-partial">
                                        {{ $ar('مدفوعة جزئياً') }}
                                    </span>

                                @else

                                    {{ $ar($bill->status ?? '—') }}

                                @endif

                            </td>


                            <td>
                                {{ $bill->issue_date?->format('Y-m-d') ?? '—' }}
                            </td>


                            <td>
                                {{ $bill->due_date?->format('Y-m-d') ?? '—' }}
                            </td>


                            <td>
                                {{ $ar($bill->notes ?? '—') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif


    @else

        <div class="empty">
            {{ $ar('لا توجد بيانات ضمن الفترة الزمنية المحددة.') }}
        </div>

    @endif


    {{-- ============================================= --}}
    {{-- أسفل التقرير --}}
    {{-- ============================================= --}}

    <div class="footer">

        <span class="footer-brand">
            Vivio
        </span>

        —

        {{ $ar('نظام إدارة المعلومات الطبية') }}

        &nbsp;&nbsp;|&nbsp;&nbsp;

        {{ $ar('تم إنشاء هذا التقرير آلياً من البيانات المسجلة في النظام') }}

    </div>

</body>

</html>