<?php

namespace App\Filament\Resources\PmserviceResource\Pages;

use App\Filament\Resources\PmserviceResource;
use App\Filament\Resources\PmserviceResource\Widgets\PmservicesWidget;
use App\Models\Pmservice;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListPmservices extends ListRecords
{


    protected static string $resource = PmserviceResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Refresh Records')
            ->action(fn () => self::updateAllRecords()),
        ];
    }

    public static function updateAllRecords()
    {

        $currentDate = Carbon::now();
        $pmservices = Pmservice::all();
    
        foreach ($pmservices as $record) {
            if ($record->status === 'cancelled') {
                continue; 
            }
    
            if ($record->end_date <= $currentDate) {
                $record->status = 'inactive';
            } elseif ($record->end_date >= $currentDate) {
                $record->status = 'active';
            }
    
            $record->save(); 
        }
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'active'))
                ->badge(Pmservice::query()->where('status', 'active')->count()),
            'inactive' => Tab::make('Inactive')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'inactive'))
                ->badge(Pmservice::query()->where('status', 'inactive')->count()),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled'))
                ->badge(Pmservice::query()->where('status', 'cancelled')->count()),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
{
    return 'active';
}

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         PmservicesWidget::class,
    //     ];
    // }

  
}
