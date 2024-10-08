<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use App\Models\Fsr;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFsr extends EditRecord
{
    protected static string $resource = FsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    

    protected function mutateFormDataBeforeFill(array $data): array
{
    $fsr = Fsr::findOrFail($data['id']);
    
    $jobDateStarted = Carbon::parse($fsr->job_date_started)->format('Y-m-d');

    if (blank($data['job_date_started'])) {
        $data['job_date_started'] = $jobDateStarted;
    }

    return $data;
}

//     public function hasCombinedRelationManagerTabsWithContent(): bool
// {
//     return true;
// }
}
