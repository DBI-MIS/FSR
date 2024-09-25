<?php

namespace App\Filament\Resources\PmserviceResource\Pages;

use App\Filament\Resources\PmserviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePmservice extends CreateRecord
{
    protected static string $resource = PmserviceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
