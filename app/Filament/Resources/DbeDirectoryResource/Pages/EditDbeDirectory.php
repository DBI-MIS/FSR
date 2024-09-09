<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDbeDirectory extends EditRecord
{
    protected static string $resource = DbeDirectoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
