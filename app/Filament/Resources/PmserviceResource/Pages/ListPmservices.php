<?php

namespace App\Filament\Resources\PmserviceResource\Pages;

use App\Filament\Resources\PmserviceResource;
use App\Filament\Resources\PmserviceResource\Widgets\PmservicesWidget;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListPmservices extends ListRecords
{


    protected static string $resource = PmserviceResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PmservicesWidget::class,
        ];
    }

  
}
