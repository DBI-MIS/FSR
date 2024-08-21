<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use Spatie\LaravelPdf\Facades\Pdf;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewFsr extends ViewRecord
{
    protected static string $resource = FsrResource::class;

    protected static ?string $title = 'FSR';


    public function getHeader(): ?View
{

    $manilaTime = Carbon::now()->setTimezone('Asia/Manila');
    $currentDate = $manilaTime->format('M d, Y');
    $currentTime = $manilaTime->format('h:i:s A');
    

    return view('infolists.components.custom-header', [
        'editUrl' => route('filament.admin.resources.fsrs.edit', $this->record->id),
        'currentDate' => $currentDate,
        'currentTime' => $currentTime,
        'backUrl' => $this->getResource()::getUrl('index'),
        
    ]);
}

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\EditAction::make(),
    //         // Actions\DeleteAction::make(),
    //     ];
    // }

}
