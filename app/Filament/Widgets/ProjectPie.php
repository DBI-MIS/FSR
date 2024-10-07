<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectPie extends ChartWidget
{
    protected int | string | array $columnSpan = '1';
    protected static bool $isLazy = true;
    protected static ?string $maxHeight = '360px';
    protected static ?string $pollingInterval = null;
    protected static ?string $heading = 'Projects / Clients';

    public function getDescription(): ?string
    {

    $filters = $this->getFilters();

    $prefix = 'Top Projects w/ ';
    
    return $prefix . ($filters[$this->filter] ?? 'NA');

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

    public ?string $filter = 'Preventive Maintenance';

    protected function getFilters(): ?array
    {
        return [
            'Preventive Maintenance' => 'Preventive Maintenance',
            'Trouble Call' => 'Trouble Call',
            'Check-up' => 'Check-up',
            'Evaluation' => 'Evaluation',
            'Start Up' => 'Start Up',
            'Testing' => 'Testing',
            'Commissioning' => 'Commissioning',
            'Monitoring' => 'Monitoring',
            'Site Inspection' => 'Site Inspection',
            'Operatorship' => 'Operatorship',
            'Parts/Installation' => 'Parts/Installation',
            'Repair/Modification' => 'Repair/Modification',
            'Hauling' => 'Hauling',
            'Delivery' => 'Delivery',
            'Retrofitting' => 'Retrofitting',
            'Others' => 'Others',
        ];
    }

    // SQLITE VERSION
    protected function getData(): array
    {
        $activeFilters = $this->filter; 
    
        $query = Project::withCount(['fsrs as filtered_fsrs_count' => function ($query) use ($activeFilters) {
            if (!empty($activeFilters)) {
                $query->whereJsonContains('attended_to', $activeFilters);
            }
        }])
        ->where('filtered_fsrs_count', '>', 0) 
        ->orderBy('filtered_fsrs_count', 'desc'); 
    
    
        $topProjects = $query->take(10)->get();
        $otherProjects = $query->skip(10)->get();
    
  
        $labels = $topProjects->pluck('name')->toArray();
        $data = $topProjects->pluck('filtered_fsrs_count')->toArray();
    
    
        if ($otherProjects->isNotEmpty()) {
            $labels[] = 'Others';
            $data[] = $otherProjects->sum('filtered_fsrs_count');
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
                    }, range(1, count($data))), 
                ],
            ],
            'labels' => $labels,
        ];
    }
    

    // MYSQL Version
//     protected function getData(): array
// {
//     $activeFilters = $this->filter; 

    
//     $query = Project::withCount(['fsrs as filtered_fsrs_count' => function ($query) use ($activeFilters) {
//         if (!empty($activeFilters)) {
//             $query->whereJsonContains('attended_to', $activeFilters);
//         }
//     }])
//     ->havingRaw('filtered_fsrs_count > 0')  
//     ->orderBy('filtered_fsrs_count', 'desc');

    
//     $topProjects = $query->take(10)->get();
//     $otherProjects = $query->skip(10)->get(); 

    
//     $labels = $topProjects->pluck('name')->toArray();
//     $data = $topProjects->pluck('filtered_fsrs_count')->toArray();

    
//     if ($otherProjects->isNotEmpty()) {
//         $labels[] = 'Others';
//         $data[] = $otherProjects->sum('filtered_fsrs_count');
//     }

//     return [
//         'datasets' => [
//             [
//                 'label' => 'FSRs Count',
//                 'data' => $data,
//                 'backgroundColor' => array_map(function () {
//                     $red = mt_rand(0, 100);
//                     $green = mt_rand(0, 100);
//                     $blue = mt_rand(155, 255);
//                     return sprintf('#%02X%02X%02X', $red, $green, $blue);
//                 }, range(1, count($data))), 
//             ],
//         ],
//         'labels' => $labels,
//     ];
// }

    protected function getType(): string
    {
        return 'pie';
    }
}
