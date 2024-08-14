<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatus extends BaseWidget
{

    protected static ?string $pollingInterval = '15s';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            
            // Stat::make('Projects / Clients', Project::where('warranty', 'Under Warranty')->count())
            // ->description('Under Warranty')
            // ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            // ->chart([1,2,4,8,16,32,64,128])
            // ->color('success'),
            // Stat::make('Out of Warranty Projects / Clients', Project::where('warranty', 'Out of Warranty')->count())
            // ->description('Out of Warranty')
            // ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            // ->chart([1,2,4,8,16,32,64,128])
            // ->color('success'),
            // Stat::make('Out of Warranty Projects / Clients', Project::where('warranty', 'In House')->count())
            // ->description('In House')
            // ->descriptionIcon('heroicon-o-pencil-square', IconPosition::Before)
            // ->chart([1,2,4,8,16,32,64,128])
            // ->color('success'),
        ];
    }
}
