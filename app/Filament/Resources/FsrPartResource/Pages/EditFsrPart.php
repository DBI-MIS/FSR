<?php

namespace App\Filament\Resources\FsrPartResource\Pages;

use App\Filament\Resources\FsrPartResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFsrPart extends EditRecord
{
    protected static string $resource = FsrPartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
