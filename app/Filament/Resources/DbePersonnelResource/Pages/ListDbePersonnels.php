<?php

namespace App\Filament\Resources\DbePersonnelResource\Pages;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;

class ListDbePersonnels extends ListRecords
{
    protected static string $resource = DbePersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
            ->color("primary")
            ->slideOver(),
            Actions\CreateAction::make(),
        ];
    }
}
