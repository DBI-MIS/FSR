<?php

namespace App\Filament\Resources\FsrEquipReplaceResource\Pages;

use App\Filament\Resources\FsrEquipReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFsrEquipReplace extends CreateRecord
{
    protected static string $resource = FsrEquipReplaceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
