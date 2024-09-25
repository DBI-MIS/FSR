<?php

namespace App\Filament\Resources\PmserviceResource\Widgets;

use App\Models\Pmservice;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Widgets\Widget;

class PmservicesWidget extends Widget
{
    use ExposesTableToWidgets;

    protected static string $view = 'filament.resources.pmservice-resource.widgets.pmservices-widget';

    protected static bool $isLazy = false;

    protected static ?string $maxHeight = '500px';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {

        // $services = Pmservice::pluck('all')->unique()->sort();

        $services = Pmservice::with('pm_project')->get()->unique()->sort();

        return [
            'services' => $services,
        ];
    }

}
