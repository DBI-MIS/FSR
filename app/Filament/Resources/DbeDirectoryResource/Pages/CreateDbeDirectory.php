<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDbeDirectory extends CreateRecord
{
    protected static string $resource = DbeDirectoryResource::class;

  

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $projectId = $data['project_id'] ?? null;

        if ($projectId) {
            $latestFsr = DB::table('fsrs')
                ->where('project_id', $projectId)
                ->orderBy('created_at', 'desc')
                ->first();
                dd($latestFsr);
            if ($latestFsr) {
                $fsrDate = Carbon::parse($latestFsr->created_at);
                $status = $fsrDate->diffInMonths(Carbon::now()) > 12 ? 'inactive' : 'active';
            } else {
                $status = 'inactive'; // No FSR found
            }

            $data['status'] = $status;
        } else {
            $data['status'] = 'inactive'; // No project selected
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
