<?php

namespace App\Filament\Resources\DbePersonnelResource\Pages;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDbePersonnel extends CreateRecord
{
    protected static string $resource = DbePersonnelResource::class;
   
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
