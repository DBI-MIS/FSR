<?php

namespace App\Filament\Resources\DbePersonnelResource\Pages;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction as ExcelImportExcelImportAction;

class ListDbePersonnels extends ListRecords
{
    protected static string $resource = DbePersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportExcelImportAction::make()
            ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}
