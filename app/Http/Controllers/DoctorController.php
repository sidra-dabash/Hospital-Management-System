<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $doctors = Doctor::with(['user', 'department'])
            ->when($request->string('search')->trim()->value(), function ($query, string $search) {
                $query->whereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%"))
                    ->orWhere('specialization', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        return view('doctors.create', ['departments' => Department::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->assignRole('doctor');

            Doctor::create([
                'user_id' => $user->id,
                'department_id' => $data['department_id'],
                'specialization' => $data['specialization'],
                'phone' => $data['phone'] ?? null,
                'salary' => $data['salary'] ?? null,
            ]);
        });

        return redirect()->route('doctors.index')->with('success', 'تمت إضافة الطبيب بنجاح.');
    }

    public function show(Doctor $doctor): View
    {
        $doctor->load(['user', 'department'])->loadCount(['appointments', 'medicalRecords']);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        $doctor->load('user');

        return view('doctors.edit', [
            'doctor' => $doctor,
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $doctor->user_id],
            'department_id' => ['required', 'exists:departments,id'],
            'specialization' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($data, $doctor) {
            $doctor->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);
            $doctor->update(collect($data)->only(['department_id', 'specialization', 'phone', 'salary'])->all());
        });

        return redirect()->route('doctors.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        if ($doctor->appointments()->exists() || $doctor->medicalRecords()->exists()) {
            return redirect()->route('doctors.index')->with('error', 'لا يمكن حذف طبيب لديه مواعيد أو سجلات طبية محفوظة.');
        }

        $doctor->user->delete();

        return redirect()->route('doctors.index')->with('success', 'تم حذف الطبيب بنجاح.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'department_id' => ['required', 'exists:departments,id'],
            'specialization' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
