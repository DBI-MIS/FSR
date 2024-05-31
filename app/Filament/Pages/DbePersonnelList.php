<?php

namespace App\Filament\Pages;

use App\Enums\DbePersonnelStatus;
use App\Models\DbePersonnel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class DbePersonnelList extends KanbanBoard
{
    protected static string $model = DbePersonnel::class;
    // protected static string $statusEnum = DbePersonnelStatus::class;
    protected static string $recordTitleAttribute = 'name';

    protected static string $recordDescriptionAttribute = 'designation';

    protected static string $recordStatusAttribute = 'status';


    protected function statuses(): Collection
    {
        return DbePersonnelStatus::statuses();          
    }

    protected function records(): Collection
    {
        // return DbePersonnel::latest('updated_at')->get();
        return DbePersonnel::ordered()->get();
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
{
    DbePersonnel::find($recordId)->update(['status' => $status]);
    DbePersonnel::setNewOrder($toOrderedIds);
}

public function onSortChanged(int $recordId, string $status, array $orderedIds): void
{
    DbePersonnel::setNewOrder($orderedIds);
}

protected function additionalRecordData(Model $record): Collection
{
    return collect([

        'photo' => $record->profile_photo_path    
    ]);
}

}
