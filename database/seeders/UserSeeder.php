<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $cardiology = Department::where('name', 'قلب')->first();
        $pediatrics = Department::where('name', 'أطفال')->first();
        $emergency = Department::where('name', 'إسعاف')->first();
        $surgery = Department::where('name', 'جراحة')->first();

        $admin = User::create([
            'name' => 'المدير العام',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        $drAhmedUser = User::create([
            'name' => 'أحمد محمود',
            'email' => 'ahmed@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $drAhmedUser->assignRole('doctor');
        Doctor::create([
            'user_id' => $drAhmedUser->id,
            'department_id' => $cardiology->id,
            'specialization' => 'استشاري أمراض القلب',
            'phone' => '01001234567',
            'salary' => 15000.00,
        ]);

        $drMohamedUser = User::create([
            'name' => 'محمد علي',
            'email' => 'mohamed@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $drMohamedUser->assignRole('doctor');
        Doctor::create([
            'user_id' => $drMohamedUser->id,
            'department_id' => $pediatrics->id,
            'specialization' => 'استشاري طب الأطفال',
            'phone' => '01007654321',
            'salary' => 12000.00,
        ]);

        $drSaraUser = User::create([
            'name' => 'سارة حسن',
            'email' => 'sara@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $drSaraUser->assignRole('doctor');
        Doctor::create([
            'user_id' => $drSaraUser->id,
            'department_id' => $surgery->id,
            'specialization' => 'استشاري جراحة عامة',
            'phone' => '01002345678',
            'salary' => 18000.00,
        ]);

        $nurse = User::create([
            'name' => 'فاطمة عبدالله',
            'email' => 'fatima@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $nurse->assignRole('nurse');

        $nurse2 = User::create([
            'name' => 'مريم إبراهيم',
            'email' => 'mariam@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $nurse2->assignRole('nurse');

        $receptionist = User::create([
            'name' => 'حسام سعيد',
            'email' => 'hossam@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $receptionist->assignRole('receptionist');

        $accountant = User::create([
            'name' => 'كريم فوزي',
            'email' => 'karim@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $accountant->assignRole('accountant');

        $demoPatient = Patient::create([
            'first_name' => 'خالد',
            'last_name' => 'محمد',
            'gender' => 'male',
            'birth_date' => '1990-05-15',
            'phone' => '01111222333',
            'address' => 'القاهرة، مصر',
            'blood_type' => 'A+',
            'emergency_contact' => '01111222444',
        ]);

        Patient::create([
            'first_name' => 'نورا',
            'last_name' => 'سالم',
            'gender' => 'female',
            'birth_date' => '1995-08-20',
            'phone' => '01122334455',
            'address' => 'الجيزة، مصر',
            'blood_type' => 'O-',
            'emergency_contact' => '01122334466',
        ]);

        Patient::create([
            'first_name' => 'عمر',
            'last_name' => 'يسري',
            'gender' => 'male',
            'birth_date' => '2018-03-10',
            'phone' => '01133445566',
            'address' => 'الإسكندرية، مصر',
            'blood_type' => 'B+',
            'emergency_contact' => '01133445577',
        ]);

        Patient::create([
            'first_name' => 'لبنى',
            'last_name' => 'عاطف',
            'gender' => 'female',
            'birth_date' => '1985-11-25',
            'phone' => '01144556677',
            'address' => 'المنصورة، مصر',
            'blood_type' => 'AB+',
            'emergency_contact' => '01144556688',
        ]);

        $patientUser = User::create([
            'name' => $demoPatient->full_name,
            'email' => 'patient@hospital.com',
            'password' => Hash::make('password123'),
        ]);
        $patientUser->assignRole('patient');
        $demoPatient->user()->associate($patientUser);
        $demoPatient->save();
    }
}
