<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;

//not working
class ProjectView extends Component
{
    public $search = '';
    public $sortedFsrs;

    public function mount(Collection $sortedFsrs)
    {
        $this->sortedFsrs = $sortedFsrs;
    }

    public function render()
    {
        $filteredFsrs = $this->sortedFsrs->filter(function ($fsr) {
            return str_contains(strtolower($fsr->fsr_no), strtolower($this->search));
        });

        return view('filament.part.project-view', [
            'filteredFsrs' => $filteredFsrs,
        ]);
    }
}
