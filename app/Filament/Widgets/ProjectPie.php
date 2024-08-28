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
    return 'Top 10 Projects with the most FSRs';
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
    // Fetch projects with FSR counts
    $projects = Project::withCount('fsrs')
        ->orderBy('fsrs_count', 'desc') // Sort projects by FSR count
        ->get();

    // Split the projects into top 10 and the rest
    $topProjects = $projects->take(10);
    $otherProjects = $projects->slice(10);

    // Labels and data for top 10 projects
    $labels = $topProjects->pluck('name')->toArray();
    $data = $topProjects->pluck('fsrs_count')->toArray();

    // Aggregate data for "Others"
    if ($otherProjects->isNotEmpty()) {
        $labels[] = 'Others';
        $data[] = $otherProjects->sum('fsrs_count');
    }

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
