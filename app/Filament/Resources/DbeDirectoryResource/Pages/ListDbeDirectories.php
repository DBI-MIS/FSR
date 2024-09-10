<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListDbeDirectories extends ListRecords
{
    protected static string $resource = DbeDirectoryResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ExcelImportAction::make()
            ->color("primary")
            ->slideOver()
            ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                $collection->each(function ($row) use ($modelClass) {

                    $contactToString = $row['contact_no'];
                    $contactToArray = explode(',', $contactToString);
                    $modelClass::create([
                        
                        'project_id' => $row['project_id'],
                        'contact_no' =>  $contactToArray,
                        'contact_person' => $row['contact_person'],
                        'designation' => $row['designation'],
                        'email_address' => $row['email_address'],
                        'fsr_id' => $row['fsr_id'],
                        'status' => $row['status'],
                    ]);
                });

                return $collection;
            }),
            Actions\CreateAction::make(),
        ];
    }
}
