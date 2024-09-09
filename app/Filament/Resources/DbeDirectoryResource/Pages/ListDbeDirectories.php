<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDbeDirectories extends ListRecords
{
    protected static string $resource = DbeDirectoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
