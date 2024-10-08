<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EditDbeDirectory extends EditRecord
{
    protected static string $resource = DbeDirectoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $projectId = $data['project_id'] ?? null;

    //     if ($projectId) {
    //         $latestFsr = DB::table('fsrs')
    //             ->where('project_id', $projectId)
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if ($latestFsr) {
    //             $fsrDate = Carbon::parse($latestFsr->job_date_started);
    //             $status = $fsrDate->diffInMonths(Carbon::now()) > 6 ? 'inactive' : 'active';
    //             $data['status'] = $status;
    //         } else {
    //             $data['status'] = 'inactive'; 
    //         }
    //     } else {
    //         $data['status'] = 'inactive'; 
    //     }

    //     return $data;
    // }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    // composer remove pxlrbt/filament-excel

}
