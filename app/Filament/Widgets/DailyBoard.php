<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Widget;

class DailyBoard extends Widget
{

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.daily-board';

    protected static bool $isDiscovered = false;

    public function getViewData(): array
    {
      

        return [
            'currentTime' => Carbon::now(),
            'user' => Auth()->user(),
        ];
    }
}
