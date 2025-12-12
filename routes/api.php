<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Soap\PatientSoapController;

Route::middleware(['auth:sanctum'])->group(function () {
Route::any('/soap/patients', [PatientSoapController::class, 'handle']);

    Route::get('/patients', [PatientController::class, 'index']);
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::put('/patients/{id}', [PatientController::class, 'update']);

    // 🔐 solo admin puede eliminar
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])
        ->middleware('role:admin');

});
