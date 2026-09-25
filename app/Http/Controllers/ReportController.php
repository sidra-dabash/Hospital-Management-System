<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * صفحة التقارير الرئيسية
     */
    public function index()
    {
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();

        $completedAppointments = Appointment::where('status', 'completed')->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $totalMedicalRecords = MedicalRecord::count();
        $totalBills = Bill::count();

        $stats = [
            [
                'label' => 'إجمالي المرضى',
                'value' => $totalPatients,
                'sub' => 'مريض مسجل',
                'icon' => 'users',
                'color' => 'primary',
            ],
            [
                'label' => 'إجمالي المواعيد',
                'value' => $totalAppointments,
                'sub' => 'موعد مسجل',
                'icon' => 'calendar',
                'color' => 'secondary',
            ],
            [
                'label' => 'المواعيد المكتملة',
                'value' => $completedAppointments,
                'sub' => 'موعد مكتمل',
                'icon' => 'calendar-check',
                'color' => 'purple',
            ],
            [
                'label' => 'المواعيد الملغاة',
                'value' => $cancelledAppointments,
                'sub' => 'موعد ملغي',
                'icon' => 'calendar-x',
                'color' => 'red',
            ],
        ];

        $chartWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $patientsCount = Patient::whereDate(
                'created_at',
                $date->toDateString()
            )->count();

            $chartWeek[] = [
                'day' => $this->arabicDayName($date),
                'patients' => $patientsCount,
            ];
        }

        $appointmentsStatus = [
            [
                'label' => 'مكتمل',
                'count' => $completedAppointments,
                'color' => 'secondary',
                'percent' => 0,
            ],
            [
                'label' => 'مؤكد',
                'count' => $confirmedAppointments,
                'color' => 'purple',
                'percent' => 0,
            ],
            [
                'label' => 'ملغي',
                'count' => $cancelledAppointments,
                'color' => 'red',
                'percent' => 0,
            ],
            [
                'label' => 'قيد الانتظار',
                'count' => $pendingAppointments,
                'color' => 'primary',
                'percent' => 0,
            ],
        ];

        foreach ($appointmentsStatus as &$status) {
            $status['percent'] = $totalAppointments > 0
                ? round(($status['count'] / $totalAppointments) * 100, 1)
                : 0;
        }

        unset($status);

        $reportTypes = [
            [
                'key' => 'patients',
                'type' => 'تقرير المرضى',
                'subject' => 'بيانات المرضى المسجلين في النظام',
                'count' => $totalPatients,
            ],
            [
                'key' => 'appointments',
                'type' => 'تقرير المواعيد',
                'subject' => 'المواعيد وحالاتها خلال الفترة المحددة',
                'count' => $totalAppointments,
            ],
            [
                'key' => 'medical_records',
                'type' => 'تقرير السجلات الطبية',
                'subject' => 'السجلات والزيارات الطبية',
                'count' => $totalMedicalRecords,
            ],
            [
                'key' => 'bills',
                'type' => 'تقرير الفواتير',
                'subject' => 'الفواتير المسجلة في النظام',
                'count' => $totalBills,
            ],
        ];

        return view('reports.index', compact(
            'stats',
            'chartWeek',
            'appointmentsStatus',
            'totalAppointments',
            'reportTypes'
        ));
    }

    /**
     * صفحة نتائج التقرير
     */
    public function results(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['type'];
        $dateFrom = $validated['date_from'];
        $dateTo = $validated['date_to'];

        if ($reportType === 'patients') {
            $query = Patient::query()
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);

            $totalResults = (clone $query)->count();

            $results = $query
                ->latest('created_at')
                ->paginate(10)
                ->withQueryString();

            $summaryStats = [
                [
                    'label' => 'عدد المرضى',
                    'value' => $totalResults,
                    'sub' => 'مريض مسجل خلال الفترة',
                    'icon' => 'users',
                    'color' => 'primary',
                ],
            ];

            $reportTitle = 'تقرير المرضى';
        } elseif ($reportType === 'appointments') {
            $query = Appointment::with([
                'patient',
                'doctor.user',
                'doctor.department',
            ])
                ->whereDate('appointment_date', '>=', $dateFrom)
                ->whereDate('appointment_date', '<=', $dateTo);

            $totalResults = (clone $query)->count();

            $completed = (clone $query)
                ->where('status', 'completed')
                ->count();

            $cancelled = (clone $query)
                ->where('status', 'cancelled')
                ->count();

            $confirmed = (clone $query)
                ->where('status', 'confirmed')
                ->count();

            $pending = (clone $query)
                ->where('status', 'pending')
                ->count();

            $results = $query
                ->orderByDesc('appointment_date')
                ->paginate(10)
                ->withQueryString();

            $summaryStats = [
                [
                    'label' => 'إجمالي المواعيد',
                    'value' => $totalResults,
                    'sub' => 'موعد خلال الفترة',
                    'icon' => 'calendar',
                    'color' => 'primary',
                ],
                [
                    'label' => 'المواعيد المكتملة',
                    'value' => $completed,
                    'sub' => 'موعد مكتمل',
                    'icon' => 'calendar-check',
                    'color' => 'secondary',
                ],
                [
                    'label' => 'المواعيد الملغاة',
                    'value' => $cancelled,
                    'sub' => 'موعد ملغي',
                    'icon' => 'calendar-x',
                    'color' => 'red',
                ],
                [
                    'label' => 'المواعيد المؤكدة',
                    'value' => $confirmed,
                    'sub' => 'موعد مؤكد',
                    'icon' => 'calendar',
                    'color' => 'purple',
                ],
                [
                    'label' => 'قيد الانتظار',
                    'value' => $pending,
                    'sub' => 'موعد قيد الانتظار',
                    'icon' => 'clock',
                    'color' => 'orange',
                ],
            ];

            $reportTitle = 'تقرير المواعيد';
        } elseif ($reportType === 'medical_records') {
            $query = MedicalRecord::with([
                'patient',
                'doctor.user',
                'doctor.department',
            ])
                ->whereDate('visit_date', '>=', $dateFrom)
                ->whereDate('visit_date', '<=', $dateTo);

            $totalResults = (clone $query)->count();

            $results = $query
                ->orderByDesc('visit_date')
                ->paginate(10)
                ->withQueryString();

            $summaryStats = [
                [
                    'label' => 'السجلات الطبية',
                    'value' => $totalResults,
                    'sub' => 'سجل طبي خلال الفترة',
                    'icon' => 'document',
                    'color' => 'secondary',
                ],
            ];

            $reportTitle = 'تقرير السجلات الطبية';
        } else {
            $query = Bill::with('patient')
                ->whereDate('issue_date', '>=', $dateFrom)
                ->whereDate('issue_date', '<=', $dateTo);

            $totalResults = (clone $query)->count();

            $paidBills = (clone $query)
                ->where('status', 'paid')
                ->count();

            $unpaidBills = (clone $query)
                ->where('status', 'unpaid')
                ->count();

            $partialBills = (clone $query)
                ->where('status', 'partial')
                ->count();

            $totalAmount = (clone $query)->sum('amount');

            $results = $query
                ->orderByDesc('issue_date')
                ->paginate(10)
                ->withQueryString();

            $summaryStats = [
                [
                    'label' => 'إجمالي الفواتير',
                    'value' => $totalResults,
                    'sub' => 'فاتورة خلال الفترة',
                    'icon' => 'document',
                    'color' => 'primary',
                ],
                [
                    'label' => 'الفواتير المدفوعة',
                    'value' => $paidBills,
                    'sub' => 'فاتورة مدفوعة',
                    'icon' => 'check',
                    'color' => 'secondary',
                ],
                [
                    'label' => 'غير المدفوعة',
                    'value' => $unpaidBills,
                    'sub' => 'فاتورة غير مدفوعة',
                    'icon' => 'x',
                    'color' => 'red',
                ],
                [
                    'label' => 'المدفوعة جزئياً',
                    'value' => $partialBills,
                    'sub' => 'فاتورة مدفوعة جزئياً',
                    'icon' => 'clock',
                    'color' => 'orange',
                ],
                [
                    'label' => 'إجمالي المبالغ',
                    'value' => number_format($totalAmount, 2),
                    'sub' => 'إجمالي قيمة الفواتير',
                    'icon' => 'money',
                    'color' => 'purple',
                ],
            ];

            $reportTitle = 'تقرير الفواتير';
        }

        $dailyChart = $this->getDailyChart(
            $reportType,
            $dateFrom,
            $dateTo
        );

        return view('reports.results', compact(
            'reportType',
            'reportTitle',
            'dateFrom',
            'dateTo',
            'summaryStats',
            'dailyChart',
            'results',
            'totalResults'
        ));
    }

    /**
     * تصدير التقرير كملف PDF حقيقي.
     */
    public function exportPdf(Request $request)
    {
        $validated = $this->validateReportRequest($request);

        $reportType = $validated['type'];
        $dateFrom = $validated['date_from'];
        $dateTo = $validated['date_to'];

        if ($reportType === 'patients') {
            $reportTitle = 'تقرير المرضى';

            $results = Patient::query()
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo)
                ->latest('created_at')
                ->get();

            $summaryStats = [
                [
                    'label' => 'عدد المرضى',
                    'value' => $results->count(),
                ],
            ];
        } elseif ($reportType === 'appointments') {
            $reportTitle = 'تقرير المواعيد';

            $results = Appointment::with([
                'patient',
                'doctor.user',
                'doctor.department',
            ])
                ->whereDate('appointment_date', '>=', $dateFrom)
                ->whereDate('appointment_date', '<=', $dateTo)
                ->orderByDesc('appointment_date')
                ->get();

            $summaryStats = [
                [
                    'label' => 'إجمالي المواعيد',
                    'value' => $results->count(),
                ],
                [
                    'label' => 'المكتملة',
                    'value' => $results->where('status', 'completed')->count(),
                ],
                [
                    'label' => 'المؤكدة',
                    'value' => $results->where('status', 'confirmed')->count(),
                ],
                [
                    'label' => 'الملغاة',
                    'value' => $results->where('status', 'cancelled')->count(),
                ],
                [
                    'label' => 'قيد الانتظار',
                    'value' => $results->where('status', 'pending')->count(),
                ],
            ];
        } elseif ($reportType === 'medical_records') {
            $reportTitle = 'تقرير السجلات الطبية';

            $results = MedicalRecord::with([
                'patient',
                'doctor.user',
                'doctor.department',
            ])
                ->whereDate('visit_date', '>=', $dateFrom)
                ->whereDate('visit_date', '<=', $dateTo)
                ->orderByDesc('visit_date')
                ->get();

            $summaryStats = [
                [
                    'label' => 'عدد السجلات الطبية',
                    'value' => $results->count(),
                ],
            ];
        } else {
            $reportTitle = 'تقرير الفواتير';

            $results = Bill::with('patient')
                ->whereDate('issue_date', '>=', $dateFrom)
                ->whereDate('issue_date', '<=', $dateTo)
                ->orderByDesc('issue_date')
                ->get();

            $summaryStats = [
                [
                    'label' => 'إجمالي الفواتير',
                    'value' => $results->count(),
                ],
                [
                    'label' => 'المدفوعة',
                    'value' => $results->where('status', 'paid')->count(),
                ],
                [
                    'label' => 'غير المدفوعة',
                    'value' => $results->where('status', 'unpaid')->count(),
                ],
                [
                    'label' => 'المدفوعة جزئياً',
                    'value' => $results->where('status', 'partial')->count(),
                ],
                [
                    'label' => 'إجمالي المبالغ',
                    'value' => number_format($results->sum('amount'), 2),
                ],
            ];
        }

        $totalResults = $results->count();

        $generatedAt = Carbon::now()->format('Y-m-d H:i');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'reportType',
            'reportTitle',
            'dateFrom',
            'dateTo',
            'results',
            'summaryStats',
            'totalResults',
            'generatedAt'
        ));

        $pdf->setPaper('a4', 'landscape');

        $fileName = 'vivio-' .
            str_replace('_', '-', $reportType) .
            '-report-' .
            $dateFrom .
            '-to-' .
            $dateTo .
            '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * التحقق من نوع التقرير والتاريخ.
     */
    private function validateReportRequest(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:patients,appointments,medical_records,bills',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);
    }

    /**
     * إنشاء بيانات الرسم البياني من قاعدة البيانات.
     */
    private function getDailyChart(
        string $reportType,
        string $dateFrom,
        string $dateTo
    ): array {
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);

        $chart = [];

        while ($start->lte($end)) {
            $date = $start->toDateString();

            if ($reportType === 'patients') {
                $value = Patient::whereDate(
                    'created_at',
                    $date
                )->count();
            } elseif ($reportType === 'appointments') {
                $value = Appointment::whereDate(
                    'appointment_date',
                    $date
                )->count();
            } elseif ($reportType === 'medical_records') {
                $value = MedicalRecord::whereDate(
                    'visit_date',
                    $date
                )->count();
            } else {
                $value = Bill::whereDate(
                    'issue_date',
                    $date
                )->count();
            }

            $chart[] = [
                'day' => $start->format('Y-m-d'),
                'value' => $value,
            ];

            $start->addDay();
        }

        return $chart;
    }

    /**
     * تحويل اسم اليوم إلى العربية.
     */
    private function arabicDayName(Carbon $date): string
    {
        $days = [
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
        ];

        return $days[$date->format('l')] ?? $date->format('l');
    }
}