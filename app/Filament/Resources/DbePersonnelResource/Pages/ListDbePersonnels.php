<?php

namespace App\Filament\Resources\DbePersonnelResource\Pages;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use Illuminate\Support\Collection;

class ListDbePersonnels extends ListRecords
{
    protected static string $resource = DbePersonnelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("primary")
                ->slideOver()
                ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                    $collection->each(function ($row) use ($modelClass) {

                        $modelClass::create([

                            'name' => $row['name'],
                            'designation' => $row['designation'],
                            
                        ]);
                    });

                    return $collection;
                }),
            Actions\CreateAction::make(),
        ];
    }
}
