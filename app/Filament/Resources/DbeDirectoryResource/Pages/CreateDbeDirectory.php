<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDbeDirectory extends CreateRecord
{
    protected static string $resource = DbeDirectoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
