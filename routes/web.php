<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillController;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $weekStart = now()->startOfDay()->subDays(6);
        $dailyActivityCounts = collect(range(0, 6))
            ->mapWithKeys(fn ($day) => [$weekStart->copy()->addDays($day)->toDateString() => 0]);

        foreach (['patients', 'doctors', 'appointments', 'medical_records'] as $table) {
            DB::table($table)
                ->selectRaw('DATE(created_at) as activity_date, COUNT(*) as total')
                ->whereBetween('created_at', [$weekStart, now()])
                ->groupBy('activity_date')
                ->get()
                ->each(function ($row) use ($dailyActivityCounts) {
                    $date = (string) $row->activity_date;
                    $dailyActivityCounts->put($date, ($dailyActivityCounts->get($date, 0)) + (int) $row->total);
                });
        }

        $dayNames = ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
        $dailyActivities = $dailyActivityCounts->map(fn ($total, $date) => [
            'date' => $date,
            'label' => $dayNames[now()->parse($date)->dayOfWeek],
            'total' => $total,
        ])->values();

        $chartXPositions = [45, 160, 265, 365, 475, 590, 740];
        $chartMax = max(1, $dailyActivities->max('total'));
        $chartCoordinates = $dailyActivities->map(fn ($activity, $index) => [
            'x' => $chartXPositions[$index],
            'y' => 235 - (int) round(($activity['total'] / $chartMax) * 180),
            'total' => $activity['total'],
        ]);
        $chartPoints = $chartCoordinates->map(fn ($point) => $point['x'].','.$point['y'])->implode(' ');
        $chartAreaPoints = $chartPoints.' 740,235 45,235';

        $activities = collect()
            ->concat(Patient::query()->latest()->limit(10)->get()->map(fn ($patient) => [
                'title' => 'تم تسجيل مريض جديد',
                'subtitle' => $patient->full_name,
                'time' => $patient->created_at,
                'type' => 'patient',
            ]))
            ->concat(Doctor::query()->with('user')->latest()->limit(10)->get()->map(fn ($doctor) => [
                'title' => 'تمت إضافة طبيب جديد',
                'subtitle' => $doctor->user?->name ?? $doctor->specialization,
                'time' => $doctor->created_at,
                'type' => 'doctor',
            ]))
            ->concat(Appointment::query()->with('patient')->latest()->limit(10)->get()->map(fn ($appointment) => [
                'title' => 'تم حجز موعد جديد',
                'subtitle' => $appointment->patient?->full_name ?? 'موعد',
                'time' => $appointment->created_at,
                'type' => 'appointment',
            ]))
            ->concat(MedicalRecord::query()->with('patient')->latest()->limit(10)->get()->map(fn ($record) => [
                'title' => 'تمت إضافة سجل طبي',
                'subtitle' => $record->patient?->full_name ?? 'سجل طبي',
                'time' => $record->created_at,
                'type' => 'report',
            ]))
            ->sortByDesc('time')
            ->take(4)
            ->values();

        return view('dashboard.admin', [
            'patientCount' => Patient::count(),
            'doctorCount' => Doctor::count(),
            'departmentCount' => Department::count(),
            'appointmentCount' => Appointment::count(),
            'activities' => $activities,
            'dailyActivities' => $dailyActivities,
            'chartPoints' => $chartPoints,
            'chartAreaPoints' => $chartAreaPoints,
            'chartCoordinates' => $chartCoordinates,
            'chartXPositions' => $chartXPositions,
        ]);
    }

    if ($user->hasAnyRole(['doctor', 'nurse', 'receptionist', 'accountant'])) {
        return view('dashboard.user', [
            'patientCount' => Patient::count(),
            'doctorCount' => Doctor::count(),
            'departmentCount' => Department::count(),
            'appointmentCount' => Appointment::count(),
        ]);
    }

    $patient = Patient::forUser($user);

    $patientAppointments = 0;
    $medicalRecordsCount = 0;
    $billsCount = 0;
    $prescriptionsCount = 0;
    $nextAppointments = collect();
    $patientRecordUrl = null;

    if ($patient) {
        $patient->loadCount([
            'appointments' => fn ($query) => $query->whereRaw(
                'COALESCE(date, DATE(appointment_date)) >= ?',
                [now()->toDateString()]
            ),
            'medicalRecords',
            'bills',
        ]);
        $patientAppointments = $patient->appointments_count;
        $medicalRecordsCount = $patient->medical_records_count;
        $billsCount = $patient->bills_count;

        $nextAppointments = Appointment::query()
            ->where('patient_id', $patient->id)
            ->where(function ($q) {
                $q->where('date', '>=', now()->toDateString())
                    ->orWhere('appointment_date', '>=', now()->toDateString());
            })
            ->orderByRaw("COALESCE(date, appointment_date) asc")
            ->orderBy('time', 'asc')
            ->limit(3)
            ->get();

        $prescriptionsCount = $patient->medicalRecords()
            ->whereNotNull('prescription')
            ->where('prescription', '!=', '')
            ->count();

        $patientRecordUrl = route('patients.record', ['id' => $patient->id]);
    } else {
        $nextAppointments = collect();
    }

    return view('dashboard.patient', compact(
        'patientAppointments',
        'medicalRecordsCount',
        'billsCount',
        'prescriptionsCount',
        'nextAppointments',
        'patientRecordUrl'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/results', [ReportController::class, 'results'])->name('results');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
    });

Route::middleware(['auth', 'role:admin|doctor|nurse|receptionist'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
});

Route::middleware(['auth', 'role:admin|doctor|receptionist'])->group(function () {
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::match(['put', 'patch'], '/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/profile/complete', [PatientController::class, 'createOwnProfile'])->name('patient.profile.create');
    Route::post('/patient/profile/complete', [PatientController::class, 'storeOwnProfile'])->name('patient.profile.store');
});

Route::middleware(['auth', 'role:admin|doctor|nurse|receptionist'])->group(function () {
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

Route::middleware(['auth', 'role:admin|doctor'])->group(function () {
    Route::get('patients/{patient}/medical-records/create', [PatientController::class, 'createMedicalRecord'])->name('patients.medical-records.create');
    Route::post('patients/{patient}/medical-records', [PatientController::class, 'storeMedicalRecord'])->name('patients.medical-records.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::resource('doctors', DoctorController::class);
    Route::resource('departments', DepartmentController::class)->except(['create', 'show', 'edit']);
});

Route::middleware(['auth', 'role:admin|accountant|patient'])->prefix('bills')->name('bills.')->group(function () {
    Route::get('/', [BillController::class, 'index'])->name('index');
});

Route::middleware(['auth', 'role:admin|accountant'])->prefix('bills')->name('bills.')->group(function () {
    Route::get('/create', [BillController::class, 'create'])->name('create');
    Route::post('/', [BillController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'role:admin|doctor|nurse|patient'])->group(function () {
    Route::get('/patients/{id}/record', [PatientController::class, 'record'])->name('patients.record');
});

Route::middleware(['auth', 'role:admin|doctor|nurse|receptionist|patient'])->prefix('appointments')->name('appointments.')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('index');
    Route::get('/create', [AppointmentController::class, 'create'])->name('create');
    Route::post('/', [AppointmentController::class, 'store'])->name('store');
    Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
});

Route::middleware(['auth', 'role:admin|doctor|nurse|receptionist'])->prefix('appointments')->name('appointments.')->group(function () {
    Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
    Route::match(['put', 'patch'], '/{appointment}', [AppointmentController::class, 'update'])->name('update');
    Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:patient'])->prefix('appointments')->name('appointments.')->group(function () {
    Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
});

require __DIR__.'/auth.php';
