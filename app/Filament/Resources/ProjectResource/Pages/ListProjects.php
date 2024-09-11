<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ExcelImportAction::make()
            ->color("primary")
            ->slideOver()
            ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                $collection->each(function ($row) use ($modelClass) {

                    $modelClass::create([
                        // 'id' => $row['id'],
                        'name' => $row['name'],
                        'warranty' => $row['warranty'],
                        'address' => $row['address'],
                    ]);
                });

                return $collection;
            }),
            Actions\CreateAction::make(),
        ];
    }
}
