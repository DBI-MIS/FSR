<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectPie extends ChartWidget
{

    // protected static ?int $sort = 4;

    protected int | string | array $columnSpan = '1';

    // protected int | string | array $columnStart = '2';

    protected static bool $isLazy = true;

    protected static ?string $maxHeight = '300px';

    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Projects / Clients';

    public function getDescription(): ?string
{
    return 'No. of FSR per Project';
}

protected static ?array $options = [
    'scales' => [
        'x' => [
            'display' => false,
        ],
        'y' => [
            'display' => false,
        ],
    ],
];

    protected function getData(): array
    {
        
        $projects = Project::withCount('fsrs')
            ->get()
            ->filter(function ($project) {
                return $project->fsrs_count > 0;
            });

        $labels = $projects->pluck('name')->toArray();

        $data = $projects->pluck('fsrs_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'FSRs Count',
                    'data' => $data,
                    'backgroundColor' => array_map(function () {
                        $red = mt_rand(0, 100);
                        $green = mt_rand(0, 100);
                        $blue = mt_rand(155, 255);
                        return sprintf('#%02X%02X%02X', $red, $green, $blue);
                    }, $data),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
