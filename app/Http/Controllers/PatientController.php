<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function createOwnProfile(): View|RedirectResponse
    {
        if (auth()->user()->patient) {
            return redirect()->route('appointments.create');
        }

        return view('patients.own-profile-create');
    }

    public function storeOwnProfile(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('patient'), 403);
        abort_if(auth()->user()->patient, 409, 'يوجد ملف مريض مرتبط بهذا الحساب بالفعل.');

        $data = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
        ]);

        $nameParts = preg_split('/\s+/u', trim(auth()->user()->name), -1, PREG_SPLIT_NO_EMPTY);
        $firstName = array_shift($nameParts) ?: auth()->user()->name;
        $lastName = implode(' ', $nameParts) ?: $firstName;

        DB::transaction(function () use ($data, $firstName, $lastName) {
            Patient::create([
                ...$data,
                'user_id' => auth()->id(),
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        });

        return redirect()->route('appointments.create')->with('success', 'تم إنشاء ملف المريض. يمكنك الآن حجز موعد.');
    }

    public function index(Request $request): View
    {
        $query = Patient::query();

        if (auth()->user()->hasRole('doctor')) {
            $doctor = auth()->user()->doctor;

            if ($doctor) {
                $doctorName = auth()->user()->name;
                $query->where(function ($query) use ($doctor, $doctorName) {
                    $query->whereHas('appointments', function ($appointments) use ($doctor, $doctorName) {
                        $appointments->where('doctor_id', $doctor->id)
                            ->orWhere(function ($legacy) use ($doctorName) {
                                $legacy->whereNull('doctor_id')
                                    ->where('doctor_name', $doctorName);
                            });
                    })->orWhereHas('medicalRecords', function ($records) use ($doctor) {
                        $records->where('doctor_id', $doctor->id);
                    })->orWhereHas('doctors', function ($doctors) use ($doctor) {
                        $doctors->where('doctors.id', $doctor->id);
                    });
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $patients = $query
            ->when($request->string('search')->trim()->value(), function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create(): View
    {
        $patientUsers = User::role('patient')->whereDoesntHave('patient')->orderBy('name')->get();

        return view('patients.create', compact('patientUsers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $patient = Patient::create($this->validated($request));

        if (auth()->user()->hasRole('doctor') && auth()->user()->doctor) {
            $patient->doctors()->attach(auth()->user()->doctor->id);
        }

        return redirect()->route('patients.index')->with('success', 'تمت إضافة المريض بنجاح.');
    }

    public function show(Patient $patient): View
    {
        $this->authorizePatientAccess($patient);
        $patient->loadCount(['appointments', 'medicalRecords', 'bills']);

        return view('patients.show', compact('patient'));
    }

    public function createMedicalRecord(Patient $patient): View
    {
        $this->authorizePatientAccess($patient, true);
        $doctors = auth()->user()->hasRole('doctor')
            ? Doctor::with('user')->whereKey(auth()->user()->doctor?->id ?? 0)->get()
            : Doctor::with('user')->orderBy('id')->get();

        return view('patients.medical-record-create', compact('patient', 'doctors'));
    }

    public function storeMedicalRecord(Request $request, Patient $patient): RedirectResponse
    {
        $this->authorizePatientAccess($patient, true);
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'visit_date' => ['required', 'date'],
            'diagnosis' => ['required', 'string'],
            'tests' => ['nullable', 'string'],
            'treatment' => ['nullable', 'string'],
            'prescription' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        if (auth()->user()->hasRole('doctor')) {
            abort_unless(auth()->user()->doctor, 403);
            $validated['doctor_id'] = auth()->user()->doctor->id;
        }

        $validated['patient_id'] = $patient->id;
        MedicalRecord::create($validated);

        return redirect()
            ->route('patients.record', $patient)
            ->with('success', 'تمت إضافة السجل الطبي بنجاح.');
    }

    public function record($id): View
    {
        $patient = Patient::findOrFail($id);
        $this->authorizePatientAccess($patient, true);

        return view('patients.record', ['patientId' => $id, 'patient' => $patient]);
    }

    public function apiRecord($id): JsonResponse
    {
        $patient = Patient::findOrFail($id);
        $this->authorizePatientAccess($patient, true);

        $patient = Patient::with([
            'medicalRecords' => function ($q) {
                $q->latest()->limit(10);
            },
            'medicalRecords.doctor.user',
            'appointments' => function ($q) {
                $q->where('appointment_date', '>=', now())->orderBy('appointment_date')->limit(5);
            },
            'bills' => function ($q) {
                $q->latest()->limit(5);
            },
        ])->findOrFail($id);

        $birthDate = \Carbon\Carbon::parse($patient->birth_date);
        $age = $birthDate->age;

        $recentRecords = [];

        foreach ($patient->medicalRecords as $mr) {
            $recentRecords[] = [
                'type' => 'زيارة طبية',
                'title' => $mr->diagnosis,
                'doctor' => $mr->doctor?->user?->name ?? '',
                'diagnosis' => $mr->diagnosis,
                'tests' => $mr->tests ?? '',
                'treatment' => $mr->treatment ?? '',
                'prescription' => $mr->prescription ?? '',
                'notes' => $mr->notes ?? '',
                'date' => $mr->visit_date ? $mr->visit_date->toDateString() : '-',
            ];
        }

        foreach ($patient->appointments as $app) {
            $recentRecords[] = [
                'type' => 'موعد طبي',
                'title' => $app->doctor_name ?? ($app->doctor ? ('د. ' . $app->doctor->first_name . ' ' . $app->doctor->last_name) : 'موعد قادم'),
                'subtitle' => $app->specialty ?? '',
                'date' => $app->date ?? ($app->appointment_date ? $app->appointment_date->toDateString() : ''),
            ];
        }

        foreach ($patient->bills as $bill) {
            $recentRecords[] = [
                'type' => 'فاتورة',
                'title' => 'فاتورة رقم ' . $bill->id . ' - ' . number_format($bill->amount ?? 0, 2) . ' ر.س',
                'subtitle' => $bill->status ?? '',
                'date' => $bill->created_at->toDateString(),
            ];
        }

        usort($recentRecords, function ($a, $b) {
            return strcmp($b['date'], $a['date']);
        });

        $prescriptionCount = 0;
        $diagnosisCount = count($patient->medicalRecords);
        foreach ($patient->medicalRecords as $mr) {
            if (!empty($mr->prescription)) {
                $prescriptionCount++;
            }
        }

        $nationalId = $patient->national_id ?? ($patient->id ? str_pad($patient->id, 10, '0', STR_PAD_LEFT) : '-');

        $data = [
            'id' => $patient->id,
            'name' => $patient->full_name,
            'national_id' => $nationalId,
            'status' => 'مريض نشط',
            'age' => $age,
            'gender' => $patient->gender === 'male' ? 'ذكر' : 'أنثى',
            'birth_date' => $patient->birth_date->format('Y-m-d'),
            'phone' => $patient->phone,
            'address' => $patient->address ?? 'غير مسجل',
            'blood_type' => $patient->blood_type ?? 'غير محدد',
            'emergency_contact' => $patient->emergency_contact ?? 'غير مسجل',
            'current_medications' => $prescriptionCount,
            'diagnoses' => $diagnosisCount,
            'tests' => $patient->medicalRecords->filter(fn ($record) => filled($record->tests))->count(),
            'upcoming_appointments' => count($patient->appointments),
            'recent_records' => array_slice($recentRecords, 0, 15),
        ];

        return response()->json($data);
    }

    public function edit(Patient $patient): View
    {
        $this->authorizePatientAccess($patient);
        $patientUsers = User::role('patient')
            ->where(function ($query) use ($patient) {
                $query->whereDoesntHave('patient')->orWhereKey($patient->user_id ?? 0);
            })
            ->orderBy('name')
            ->get();

        return view('patients.edit', compact('patient', 'patientUsers'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $this->authorizePatientAccess($patient);
        $patient->update($this->validated($request, $patient));

        return redirect()->route('patients.index')->with('success', 'تم تحديث بيانات المريض بنجاح.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        if ($patient->appointments()->exists() || $patient->medicalRecords()->exists() || $patient->bills()->exists()) {
            return redirect()->route('patients.index')->with('error', 'لا يمكن حذف مريض لديه مواعيد أو سجلات طبية أو فواتير.');
        }

        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'تم حذف المريض بنجاح.');
    }

    private function authorizePatientAccess(Patient $patient, bool $medicalData = false): void
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'nurse'])) {
            return;
        }

        if ($user->hasRole('patient')) {
            abort_unless(Patient::forUser($user)?->is($patient), 403);
            return;
        }

        if ($user->hasRole('receptionist') && !$medicalData) {
            return;
        }

        if ($user->hasRole('doctor')) {
            $doctor = $user->doctor;
            abort_unless($doctor, 403);
            $isAssigned = $patient->doctors()->whereKey($doctor->id)->exists()
                || $patient->appointments()->where(function ($query) use ($doctor, $user) {
                    $query->where('doctor_id', $doctor->id)
                        ->orWhere(function ($legacy) use ($user) {
                            $legacy->whereNull('doctor_id')->where('doctor_name', $user->name);
                        });
                })->exists()
                || $patient->medicalRecords()->where('doctor_id', $doctor->id)->exists();
            abort_unless($isAssigned, 403);
            return;
        }

        abort(403);
    }

    private function validated(Request $request, ?Patient $patient = null): array
    {
        $userIdRule = Rule::unique('patients', 'user_id');
        if ($patient) {
            $userIdRule->ignore($patient->id);
        }

        return $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
            'user_id' => [
                'nullable',
                'exists:users,id',
                $userIdRule,
            ],
        ]);
    }
}
