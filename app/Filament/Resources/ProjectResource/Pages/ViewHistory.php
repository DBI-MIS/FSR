<?php




namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Http\Request;

class ViewHistory extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'History';

    protected static string $view = 'filament.part.project-history-view';

    protected function getViewData(): array
    {
        $project = $this->record;
        $request = request();


        $attendedToFilter = $request->input('attended_to');
        


        $query = $project->fsrs()
            ->select('job_date_started', 'fsr_no', 'attended_to', 'concerns', 'service_rendered', 'recommendation', 'project_id')
            ->orderBy('job_date_started', 'desc');


        if (!empty($attendedToFilter)) {
            $query->where(function ($q) use ($attendedToFilter) {
                $q->whereJsonContains('attended_to', $attendedToFilter);
            });
        }

        $fsrs = $query->paginate(10);


        return [
            'fsrs' => $fsrs,
        ];
    }
}
