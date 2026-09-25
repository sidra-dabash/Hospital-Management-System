<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Patients
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',

            // Doctors
            'view doctors',
            'create doctors',
            'edit doctors',
            'delete doctors',

            // Appointments
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'view own appointments',

            // Medical Records
            'view medical records',
            'create medical records',
            'edit medical records',
            'delete medical records',
            'view own medical records',

            // Departments
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',

            // Rooms
            'view rooms',
            'create rooms',
            'edit rooms',
            'delete rooms',

            // Bills
            'view bills',
            'create bills',
            'edit bills',
            'delete bills',

            // Payments
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $doctorRole = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        $doctorRole->givePermissionTo([
            'view patients',
            'create patients',
            'edit patients',
            'view own appointments',
            'view appointments',
            'view own medical records',
            'create medical records',
            'edit medical records',
            'view doctors',
        ]);

        $nurseRole = Role::firstOrCreate(['name' => 'nurse', 'guard_name' => 'web']);
        $nurseRole->givePermissionTo([
            'view patients',
            'view appointments',
            'view rooms',
            'view medical records',
            'view departments',
        ]);

        $receptionistRole = Role::firstOrCreate(['name' => 'receptionist', 'guard_name' => 'web']);
        $receptionistRole->givePermissionTo([
            'view patients',
            'create patients',
            'edit patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'view doctors',
            'view departments',
            'view rooms',
        ]);

        $accountantRole = Role::firstOrCreate(['name' => 'accountant', 'guard_name' => 'web']);
        $accountantRole->givePermissionTo([
            'view bills',
            'create bills',
            'edit bills',
            'delete bills',
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',
            'view patients',
        ]);

        $patientRole = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);
        $patientRole->givePermissionTo([
            'view appointments',
            'view medical records',
            'view bills',
        ]);
    }
}
