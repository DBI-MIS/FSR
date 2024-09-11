<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDbeDirectory extends ViewRecord
{
    protected static string $resource = DbeDirectoryResource::class;
    protected static ?string $title = 'Directory';
    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    
}
