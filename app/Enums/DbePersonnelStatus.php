<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum DbePersonnelStatus: string
{
    use IsKanbanStatus;

    case Waiting = 'waiting';
    case InOffice = 'in_office';
    case OnSite = 'on_site';
    

    public function getTitle(): string
    {
        return $this->name;
    }
}
