<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    private const STATUS_VALUES = ['pending', 'confirmed', 'cancelled', 'completed'];

    private function isStaff(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'doctor', 'nurse', 'receptionist']);
    }

    private function canManageAppointments(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'doctor', 'nurse', 'receptionist']);
    }

    private function getPatientIdForCurrentUser(): ?int
    {
        if (!auth()->check()) {
            return null;
        }
        $user = auth()->user();
        $patient = Patient::forUser($user);

        return $patient?->id;
    }

    private function filterForPatient($query, $patientId)
    {
        if ($patientId) {
            return $query->where('patient_id', $patientId);
        }

        return $query->whereRaw('1 = 0');
    }

    public function index(Request $request): View
    {
        $isStaff = $this->isStaff();
        $patientId = !$isStaff ? $this->getPatientIdForCurrentUser() : null;

        if ($request->wantsJson() || $request->is('api/*')) {
            abort(404);
        }

        $query = Appointment::query();

        if (auth()->user()->hasRole('doctor')) {
            $doctor = auth()->user()->doctor;

            $query->where(function ($doctorAppointments) use ($doctor) {
                if ($doctor) {
                    $doctorAppointments->where('doctor_id', $doctor->id);
                }

                // Include older appointments that were saved by name without doctor_id.
                $doctorAppointments->orWhere(function ($legacyAppointments) use ($doctor) {
                    $legacyAppointments->whereNull('doctor_id')
                        ->where('doctor_name', auth()->user()->name);
                });
            });
        } elseif (!$isStaff) {
            $query = $this->filterForPatient($query, $patientId);
        }

        $appointments = $query
            ->orderByRaw("COALESCE(date, appointment_date) desc")
            ->orderBy('time', 'desc')
            ->get()
            ->map(function (Appointment $appointment) {
                if (!$appointment->date && $appointment->appointment_date) {
                    $appointment->date = $appointment->appointment_date->toDateString();
                }
                if (!$appointment->time && $appointment->appointment_date) {
                    $appointment->time = $appointment->appointment_date->format('H:i');
                }

                return $appointment;
            });

        $canManageAppointments = $this->canManageAppointments();

        return view('appointments.index', compact('isStaff', 'appointments', 'canManageAppointments'));
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->hasRole('patient') && !$this->getPatientIdForCurrentUser()) {
            return redirect()->route('patient.profile.create');
        }
        abort_unless(!auth()->user()->hasRole('doctor') || auth()->user()->doctor, 403, 'حساب الطبيب غير مرتبط بملف طبيب.');
        $isStaff = $this->isStaff();
        $defaultPatientName = null;
        $defaultPatientId = null;
        $defaultDoctorName = null;
        $defaultSpecialty = null;
        $defaultDoctorId = null;
        $availableDoctors = Doctor::with('user')->orderBy('id')->get()->map(fn (Doctor $doctor) => [
                'id' => $doctor->id,
                'name' => $doctor->user?->name ?? ('طبيب #' . $doctor->id),
                'specialty' => $doctor->specialization,
            ])->values();

        if (!$isStaff) {
            $defaultPatientName = auth()->user()->name;
            $defaultPatientId = $this->getPatientIdForCurrentUser();
        }

        if (auth()->user()->hasRole('doctor')) {
            $doctor = auth()->user()->doctor;
            $defaultDoctorName = auth()->user()->name;
            $defaultSpecialty = $doctor?->specialization;
            $defaultDoctorId = $doctor?->id;
        }

        return view('appointments.create', compact(
            'isStaff',
            'defaultPatientName',
            'defaultPatientId',
            'defaultDoctorName',
            'defaultSpecialty',
            'defaultDoctorId',
            'availableDoctors'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $isStaff = $this->isStaff();
        abort_unless($isStaff || $this->getPatientIdForCurrentUser(), 403, 'يجب ربط حسابك بملف مريض قبل حجز موعد.');
        abort_unless(!auth()->user()->hasRole('doctor') || auth()->user()->doctor, 403, 'حساب الطبيب غير مرتبط بملف طبيب.');
        $this->setCurrentDoctorDetails($request);
        $validated = $this->validateAppointment($request);

        if (!$isStaff) {
            $patient = Patient::findOrFail($this->getPatientIdForCurrentUser());
            $validated['patient_name'] = $patient->full_name;
            $validated['patient_id'] = $patient->id;
            if (empty($validated['status'])) {
                $validated['status'] = 'pending';
            }
        } elseif (empty($validated['patient_id'])) {
            $patient = Patient::query()->get()->first(
                fn (Patient $patient) => trim($patient->full_name) === trim($validated['patient_name'])
            );

            if ($patient) {
                $validated['patient_id'] = $patient->id;
            }
        }

        Appointment::create($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'تم إضافة الموعد بنجاح!');
    }

    public function show(Appointment $appointment): View
    {
        $this->authorizeAppointmentAccess($appointment);
        $isStaff = $this->isStaff();

        return view('appointments.show', compact('appointment', 'isStaff'));
    }

    public function edit(Appointment $appointment): View
    {
        $this->authorizeAppointmentAccess($appointment);
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointmentAccess($appointment);
        $this->setCurrentDoctorDetails($request);
        $validated = $this->validateAppointment($request, true, $appointment);
        $appointment->update($validated);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'تم تحديث الموعد بنجاح!');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $this->authorizeAppointmentAccess($appointment);
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح!');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('patient'), 403);
        $this->authorizeAppointmentAccess($appointment);

        $appointmentAt = $appointment->appointment_date
            ?? Carbon::parse(($appointment->date?->toDateString() ?? $appointment->date) . ' ' . ($appointment->time ?? '00:00'));

        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'هذا الموعد ملغي بالفعل.');
        }

        if ($appointmentAt->lessThanOrEqualTo(now()->addHours(24))) {
            return back()->with('error', 'يمكن إلغاء الموعد قبل 24 ساعة على الأقل من موعده.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'تم إلغاء الموعد بنجاح.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $isStaff = $this->isStaff();
        $query = Appointment::query();

        if (auth()->user()->hasRole('doctor')) {
            $doctor = auth()->user()->doctor;

            $query->where(function ($doctorAppointments) use ($doctor) {
                if ($doctor) {
                    $doctorAppointments->where('doctor_id', $doctor->id);
                }

                $doctorAppointments->orWhere(function ($legacyAppointments) {
                    $legacyAppointments->whereNull('doctor_id')
                        ->where('doctor_name', auth()->user()->name);
                });
            });
        } elseif (!$isStaff) {
            $patientId = $this->getPatientIdForCurrentUser();
            $query = $this->filterForPatient($query, $patientId);
        }

        $appointments = $query
            ->orderByRaw("COALESCE(date, appointment_date) desc")
            ->orderBy('time', 'desc')
            ->get();

        return response()->json($appointments->map(function (Appointment $appointment) {
            if (!$appointment->date && $appointment->appointment_date) {
                $appointment->date = $appointment->appointment_date->toDateString();
            }
            if (!$appointment->time && $appointment->appointment_date) {
                $appointment->time = $appointment->appointment_date->format('H:i');
            }

            return $appointment;
        }));
    }

    public function apiStore(Request $request): JsonResponse
    {
        try {
            $isStaff = $this->isStaff();
            abort_unless($isStaff || $this->getPatientIdForCurrentUser(), 403, 'يجب ربط حسابك بملف مريض قبل حجز موعد.');
            abort_unless(!auth()->user()->hasRole('doctor') || auth()->user()->doctor, 403, 'حساب الطبيب غير مرتبط بملف طبيب.');
            $this->setCurrentDoctorDetails($request);
            $validated = $this->validateAppointment($request);

            if (!$isStaff) {
                $patient = Patient::findOrFail($this->getPatientIdForCurrentUser());
                $validated['patient_name'] = $patient->full_name;
                $validated['patient_id'] = $patient->id;
                if (empty($validated['status'])) {
                    $validated['status'] = 'pending';
                }
            } elseif (empty($validated['patient_id'])) {
                $patient = Patient::query()->get()->first(
                    fn (Patient $patient) => trim($patient->full_name) === trim($validated['patient_name'])
                );

                if ($patient) {
                    $validated['patient_id'] = $patient->id;
                }
            }

            $appointment = Appointment::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الموعد بنجاح!',
                'data' => $appointment,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الموعد',
                'error' => 'تعذر حفظ الموعد حاليًا. حاول مرة أخرى.',
            ], 500);
        }
    }

    private function setCurrentDoctorDetails(Request $request): void
    {
        $user = auth()->user();
        if ($user?->hasRole('doctor') && $user->doctor) {
            $doctor = $user->doctor;
            $request->merge([
                'doctor_name' => $user->name,
                'specialty' => $doctor->specialization,
                'doctor_id' => $doctor->id,
            ]);
        } elseif ($request->filled('doctor_id')) {
            $doctor = Doctor::with('user')->find($request->input('doctor_id'));
            if ($doctor) {
                $request->merge([
                    'doctor_name' => $doctor->user?->name ?? ('طبيب #' . $doctor->id),
                    'specialty' => $doctor->specialization,
                    'doctor_id' => $doctor->id,
                ]);
            }
        }
    }

    private function authorizeAppointmentAccess(Appointment $appointment): void
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'nurse', 'receptionist'])) {
            return;
        }

        if ($user->hasRole('doctor')) {
            $doctor = $user->doctor;
            abort_unless($doctor && (
                (int) $appointment->doctor_id === (int) $doctor->id ||
                ($appointment->doctor_id === null && $appointment->doctor_name === $user->name)
            ), 403);
            return;
        }

        if ($user->hasRole('patient')) {
            $patientId = $this->getPatientIdForCurrentUser();
            abort_unless($patientId && (int) $appointment->patient_id === (int) $patientId, 403);
            return;
        }

        abort(403);
    }

    private function validateAppointment(Request $request, bool $isUpdate = false, ?Appointment $appointment = null): array
    {
        $legacyStatuses = [
            'قيد الانتظار' => 'pending',
            'مؤكد' => 'confirmed',
            'ملغي' => 'cancelled',
            'تم التأجيل' => 'completed',
        ];

        if ($request->filled('status') && isset($legacyStatuses[$request->input('status')])) {
            $request->merge(['status' => $legacyStatuses[$request->input('status')]]);
        }

        $dateRule = $isUpdate ? 'required|date' : 'required|date|after_or_equal:today';
        $doctorIdRule = $isUpdate
            ? 'nullable|exists:doctors,id'
            : 'required|exists:doctors,id';

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'date' => $dateRule,
            'time' => 'required',
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUS_VALUES)],
            'notes' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
            'doctor_id' => $doctorIdRule,
        ], [
            'patient_name.required' => 'اسم المريض مطلوب',
            'doctor_name.required' => 'اسم الطبيب مطلوب',
            'date.required' => 'تاريخ الموعد مطلوب',
            'date.after_or_equal' => 'تاريخ الموعد يجب أن يكون اليوم أو بعده',
            'time.required' => 'وقت الموعد مطلوب',
            'status.required' => 'حالة الموعد مطلوبة',
            'status.in' => 'حالة الموعد غير صالحة',
        ]);

        $validated['appointment_date'] = $validated['date'] . ' ' . $validated['time'];

        return $validated;
    }
}
