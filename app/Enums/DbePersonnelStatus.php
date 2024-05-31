<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum DbePersonnelStatus: string
{
    use IsKanbanStatus;

    case Waiting = 'waiting';
    case OnSite = 'on_site';
    case InOffice = 'in_office';

    public function getTitle(): string
    {
        return $this->name;
    }
}
