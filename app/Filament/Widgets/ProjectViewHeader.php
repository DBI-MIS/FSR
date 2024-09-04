<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\ProjectResource\Pages\ViewProject;
use App\Models\Project;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Http\Client\Request;

class ProjectViewHeader extends Widget
{

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.project-view-header';

    protected static bool $shouldRegisterNavigation = false;

    public Project $record;


    protected function getViewData(): array
    {

        // $project = $this->record;
        // $project = Project::find($projectId);
      

        return [
            // 'projectName' => $project->name,
            // dd($projectId),
        ];
    }
}
