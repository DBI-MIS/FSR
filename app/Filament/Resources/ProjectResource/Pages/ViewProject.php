<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'Project Timeline';


    public function getHeader(): ?View
{

    $manilaTime = Carbon::now()->setTimezone('Asia/Manila');
    $currentDate = $manilaTime->format('M d, Y');
    $currentTime = $manilaTime->format('h:i:s A');
    

    return view('filament.part.project-custom-header', [
        'currentDate' => $currentDate,
        'currentTime' => $currentTime,
        'backUrl' => $this->getResource()::getUrl('index'),
        'projectName' => $this->record->name, 

        
    ]);
}

    
}
