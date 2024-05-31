<?php

namespace App\Filament\Resources\FsrEquipReplaceResource\Pages;

use App\Filament\Resources\FsrEquipReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFsrEquipReplaces extends ListRecords
{
    protected static string $resource = FsrEquipReplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
