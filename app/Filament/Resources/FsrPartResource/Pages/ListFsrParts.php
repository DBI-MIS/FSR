<?php

namespace App\Filament\Resources\FsrPartResource\Pages;

use App\Filament\Resources\FsrPartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFsrParts extends ListRecords
{
    protected static string $resource = FsrPartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
