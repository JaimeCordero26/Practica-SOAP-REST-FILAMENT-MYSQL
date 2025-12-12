<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Soap\PatientSoapController;

Route::match(['GET', 'POST'], '/soap/patients', [PatientSoapController::class, 'handle']);

Route::get('/', function () {
    return view('welcome');
});
