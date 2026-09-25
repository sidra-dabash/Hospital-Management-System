<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_unlinked_patient_can_complete_profile_and_book_with_own_identity(): void
    {
        $patientUser = User::factory()->create(['name' => 'Test Patient']);
        $patientUser->assignRole('patient');

        $this->actingAs($patientUser)
            ->get(route('appointments.create'))
            ->assertRedirect(route('patient.profile.create'));

        $this->post(route('patient.profile.store'), [
            'gender' => 'female',
            'birth_date' => '1995-01-01',
            'phone' => '0501234567',
        ])->assertRedirect(route('appointments.create'));

        $patient = Patient::where('user_id', $patientUser->id)->firstOrFail();
        $department = Department::create(['name' => 'Cardiology']);
        $doctorUser = User::factory()->create(['name' => 'Test Doctor']);
        $doctorUser->assignRole('doctor');
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $department->id,
            'specialization' => 'Cardiology',
        ]);

        $bookingResponse = $this->postJson('/api/appointments', [
            'patient_name' => 'Someone Else',
            'doctor_id' => $doctor->id,
            'date' => now()->addDay()->toDateString(),
            'time' => '09:00',
            'status' => 'pending',
        ]);
        $bookingResponse->assertCreated();

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'patient_name' => $patient->full_name,
            'doctor_id' => $doctor->id,
        ]);
    }

    public function test_patient_cannot_view_another_patients_appointment(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('patient');
        $ownerPatient = Patient::create([
            'user_id' => $owner->id,
            'first_name' => 'Owner',
            'last_name' => 'Patient',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'phone' => '0501111111',
        ]);

        $other = User::factory()->create();
        $other->assignRole('patient');
        Patient::create([
            'user_id' => $other->id,
            'first_name' => 'Other',
            'last_name' => 'Patient',
            'gender' => 'female',
            'birth_date' => '1992-01-01',
            'phone' => '0502222222',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $ownerPatient->id,
            'patient_name' => $ownerPatient->full_name,
            'doctor_name' => 'Test Doctor',
            'date' => now()->addDay()->toDateString(),
            'time' => '09:00',
            'appointment_date' => now()->addDay()->setTime(9, 0),
            'status' => 'pending',
        ]);

        $this->actingAs($other)
            ->get(route('appointments.show', $appointment))
            ->assertForbidden();
    }
}
