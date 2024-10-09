<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Widget;

class HeaderWidget extends Widget
{
    // protected static ?int $sort = 2;

    protected int | string | array $columnSpan = '1';

    // protected int | string | array $columnStart = '2';

    protected static bool $isLazy = true;

    protected static string $view = 'filament.widgets.header-widget';

    public function getViewData(): array
    {

        return [
            'currentTime' => Carbon::now(),
            // 'user' => Auth()->user(),
        ];
    }

    
}
