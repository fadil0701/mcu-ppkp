<?php

namespace App\Filament\Resources\McuResultResource\Pages;

use App\Filament\Resources\McuResultResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMcuResult extends CreateRecord
{
    protected static string $resource = McuResultResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['uploaded_by'] = $user?->email ?? $user?->name ?? 'system';
        return $data;
    }
}
