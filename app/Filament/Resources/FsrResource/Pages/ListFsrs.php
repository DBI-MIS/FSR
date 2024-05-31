<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use Filament\Actions;
use EightyNine\ExcelImport\ExcelImportAction as ExcelImportExcelImportAction;
use Filament\Resources\Pages\ListRecords;

class ListFsrs extends ListRecords
{
    protected static string $resource = FsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportExcelImportAction::make()
            ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}
