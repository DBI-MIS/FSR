<?php

namespace App\Filament\Widgets;

use App\Models\Fsr;
use App\Models\Project;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class FsrTotalOverview extends Widget
{

    // protected static ?int $sort = 1;

    protected int | string | array $columnSpan = '1';

    // protected int | string | array $columnStart = '1';

    protected static bool $isLazy = true;

    protected static string $view = 'filament.widgets.fsr-total-overview';

    public function getViewData(): array
    
    {

        $counts = [
            'fsr' => Fsr::count(),
            'project' => Project::count(),
        ];

        return [
            // 'currentTime' => Carbon::now(),
            // 'user' => Auth()->user(),
            'counts' => $counts,
        ];
    }
}
