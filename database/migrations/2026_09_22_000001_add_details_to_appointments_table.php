<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'patient_name')) {
                $table->string('patient_name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('appointments', 'doctor_name')) {
                $table->string('doctor_name')->nullable()->after('patient_name');
            }
            if (!Schema::hasColumn('appointments', 'specialty')) {
                $table->string('specialty')->nullable()->after('doctor_name');
            }
            if (!Schema::hasColumn('appointments', 'date')) {
                $table->date('date')->nullable()->after('specialty');
            }
            if (!Schema::hasColumn('appointments', 'time')) {
                $table->time('time')->nullable()->after('date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('appointments', 'patient_name')) $columnsToDrop[] = 'patient_name';
            if (Schema::hasColumn('appointments', 'doctor_name')) $columnsToDrop[] = 'doctor_name';
            if (Schema::hasColumn('appointments', 'specialty')) $columnsToDrop[] = 'specialty';
            if (Schema::hasColumn('appointments', 'date')) $columnsToDrop[] = 'date';
            if (Schema::hasColumn('appointments', 'time')) $columnsToDrop[] = 'time';
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
