<?php

namespace App\Filament\Pages;

use App\Enums\DbePersonnelStatus;
use App\Models\DbePersonnel;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class DbeDailyBoard extends KanbanBoard
{
    protected static string $model = DbePersonnel::class;

    protected static string $statusEnum = DbePersonnelStatus::class;

    protected static string $recordTitleAttribute = 'name';

    protected static string $recordDescriptionAttribute = 'status_location';

    protected static string $recordStatusAttribute = 'status';

    protected static ?int $navigationSort = 20;

    protected static ?string $title = 'Daily Board';

    protected static ?string $navigationGroup = 'Personnels';

    protected string $editModalTitle = 'Edit Location';

    protected string $editModalWidth = '2xl';

    protected string $editModalSaveButtonLabel = 'Save';

    protected string $editModalCancelButtonLabel = 'Cancel';

    protected bool $editModalSlideOver = true;

    protected static string $view = 'filament.daily-kanban.kanban-board';

    protected static string $headerView = 'filament.daily-kanban.kanban-header';

    protected static string $recordView = 'filament.daily-kanban.kanban-record';

    protected static string $statusView = 'filament.daily-kanban.kanban-status';

    protected static string $scriptsView = 'filament.daily-kanban.kanban-scripts';

    protected function records(): Collection
    {
        return DbePersonnel::ordered()->where('employee_status', 'Active')->get();
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('status_location')->label('Site Location'),
        ];
    }

    protected function editRecord($recordId, array $data, array $state): void
    {
        DbePersonnel::find($recordId)->update([
            'status_location' => $data['status_location']
        ]);
    }

    protected function additionalRecordData(DbePersonnel $record): Collection
    {
        
        $groupedRecords = DbePersonnel::all()->groupBy('status_location');

    return $groupedRecords->map(function ($records, $location) {
        return collect([
            'location' => $location,
            'records' => $records->map(function ($record) {
                return collect([
                    'photo' => $record->profile_photo_path,
                    'location' => $record->status_location,
                ]);
            }),
        ]);
    });
    }
}
