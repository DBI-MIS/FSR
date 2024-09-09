<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Equipment;
use App\Models\Project;
use Filament\Resources\Pages\ViewRecord;

class ViewEquipments extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'Equipment';

    protected static string $view = 'filament.part.project-equipment-view';

    protected function getViewData(): array
    {
        $project = $this->record;
        
        $uniqueEquipments = $project->fsrs->flatMap(function($fsr) {
            return $fsr->equipments;
        })->unique('serial')->sortBy('serial');

        return [
            'uniqueEquipments' => $uniqueEquipments,
        ];
    }
    
}
