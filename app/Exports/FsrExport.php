<?php
namespace App\Exports;
namespace App\Exports;

use App\Models\Fsr;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FsrExport implements FromQuery, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Fsr::query();

        // Apply FSR number filter
        if (!empty($this->filters['fsr_no'])) {
            $query->where('fsr_no', 'like', '%' . $this->filters['fsr_no'] . '%');
        }

        // Apply duplicate/unique filter
        if (!empty($this->filters['fsr_no_duplicate'])) {
            if ($this->filters['fsr_no_duplicate'] === 'duplicate') {
                $query->whereIn('fsr_no', function ($subQuery) {
                    $subQuery->select('fsr_no')
                        ->from('fsrs')
                        ->groupBy('fsr_no')
                        ->havingRaw('COUNT(fsr_no) > 1');
                });
            } elseif ($this->filters['fsr_no_duplicate'] === 'unique') {
                $query->whereNotIn('fsr_no', function ($subQuery) {
                    $subQuery->select('fsr_no')
                        ->from('fsrs')
                        ->groupBy('fsr_no')
                        ->havingRaw('COUNT(fsr_no) > 1');
                });
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID', 'FSR No', 'User ID', 'Time Arrived', 'Time Completed', 
            'Job Date Started', 'Job Date Finished', 'Project ID', 'concerns','service_rendered', 
            'recommendation'
        ];
    }
}
