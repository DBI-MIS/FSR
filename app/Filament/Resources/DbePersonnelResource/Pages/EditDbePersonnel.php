<?php

namespace App\Filament\Resources\DbePersonnelResource\Pages;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDbePersonnel extends EditRecord
{
    protected static string $resource = DbePersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
