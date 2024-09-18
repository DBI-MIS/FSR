<?php

namespace App\Filament\Widgets;

use App\Models\Fsr;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class HeaderWidgetLite extends Widget
{

    // protected static ?int $sort = 3;

    protected int | string | array $columnSpan = '1';

    // protected int | string | array $columnStart = '1';

    protected static bool $isLazy = true;

    protected static string $view = 'filament.widgets.header-widget-lite';

    public function getViewData(): array
    {

        $counts = [
            'Preventive Maintenance' => Fsr::whereJsonContains('attended_to', 'Preventive Maintenance')->count(),
            'Trouble Call' => Fsr::whereJsonContains('attended_to', 'Trouble Call')->count(),
            'Check Up' => Fsr::whereJsonContains('attended_to', 'Check-up')->count(),
            'Evaluation' => Fsr::whereJsonContains('attended_to', 'Evaluation')->count(),
            'Start Up' => Fsr::whereJsonContains('attended_to', 'Start Up')->count(),
            'Testing' => Fsr::whereJsonContains('attended_to', 'Testing')->count(),
            'Commissioning' => Fsr::whereJsonContains('attended_to', 'Commissioning')->count(),
            'Monitoring' => Fsr::whereJsonContains('attended_to', 'Monitoring')->count(),
            'Site Inspection' => Fsr::whereJsonContains('attended_to', 'Site Inspection')->count(),
            'Operatorship' => Fsr::whereJsonContains('attended_to', 'Operatorship')->count(),
            'Parts/Installation' => Fsr::whereJsonContains('attended_to', 'Parts/Installation')->count(),
            'Repair/Modification' => Fsr::whereJsonContains('attended_to', 'Repair/Modification')->count(),
            'Hauling' => Fsr::whereJsonContains('attended_to', 'Hauling')->count(),
            'Delivery' => Fsr::whereJsonContains('attended_to', 'Delivery')->count(),
            'Retrofitting' => Fsr::whereJsonContains('attended_to', 'Retrofitting')->count(),
            'Others' => Fsr::whereJsonContains('attended_to', 'Others')->count(),
        ];

        return [
            'currentTime' => Carbon::now(),
            'user' => Auth()->user(),
            'counts' => $counts,
        ];
    }
}
