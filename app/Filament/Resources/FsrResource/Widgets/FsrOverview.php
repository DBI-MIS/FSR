<?php

namespace App\Filament\Resources\FsrResource\Widgets;

use App\Models\Fsr;
use App\Models\Project;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FsrOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            Stat::make('Totla No. of Field Service Report', Fsr::count())
            // ->description('Total No. of Field Service Report')
            ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            ->chart([1,2,4,8,16,32,64,128])
            ->color('success'),
            Stat::make('Projects / Clients', Project::count())
            // ->description('Total No. of Field Service Report')
            ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            ->chart([1,2,4,8,16,32,64,128])
            ->color('success'),
            Stat::make('Out of Warranty Projects / Clients', Project::where('warranty', 'Out of Warranty')->count())
            // ->description('Total No. of Field Service Report')
            ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            ->chart([1,2,4,8,16,32,64,128])
            ->color('success'),
        ];
    }
}
