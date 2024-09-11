<?php

namespace App\Filament\Resources\DbeDirectoryResource\Pages;

use App\Filament\Resources\DbeDirectoryResource;
use Carbon\Carbon;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;

class CreateDbeDirectory extends CreateRecord
{
    protected static string $resource = DbeDirectoryResource::class;
    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     $status = 'inactive';
    
    
    //     if (isset($data['project_id'])) {
    //         $projectId = $data['project_id'];
            
        
    //         $latestFsr = DB::table('fsrs')
    //             ->where('project_id', $projectId)
    //             ->orderBy('created_at', 'desc')
    //             ->first();
            
            
    //         if ($latestFsr) {
              
    //             dd($latestFsr);
    
         
    //             $fsrDate = Carbon::parse($latestFsr->job_date_started);
    //             $status = $fsrDate->diffInMonths(Carbon::now()) > 12 ? 'inactive' : 'active';
    //         }
            
           
    //         // dd($status);
            
            
    //         $data['status'] = $status;
    //     }
    
     
    //     // dd($data);
    
    //     return $data;
    // }
    
    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
