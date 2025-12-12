<?php

namespace App\Filament\AdminPanel\Resources\PatientResource\Pages;

use App\Filament\AdminPanel\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
}
