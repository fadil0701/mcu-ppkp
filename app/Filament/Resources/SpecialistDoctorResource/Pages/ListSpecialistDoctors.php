<?php

namespace App\Filament\Resources\SpecialistDoctorResource\Pages;


use App\Filament\Resources\SpecialistDoctorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListSpecialistDoctors extends ListRecords
{
    protected static string $resource = SpecialistDoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
