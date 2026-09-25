<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;

Route::middleware(['web', 'auth', 'role:admin|doctor|nurse|receptionist|patient'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'apiIndex'])->name('api.appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'apiStore'])->name('api.appointments.store');
});

Route::middleware(['web', 'auth', 'role:admin|doctor|nurse|patient'])->group(function () {
    Route::get('/patients/{id}/record', [PatientController::class, 'apiRecord'])->name('api.patients.record');
});
