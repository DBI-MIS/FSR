<?php

namespace App\Filament\Resources\FsrPartResource\Pages;

use App\Filament\Resources\FsrPartResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFsrPart extends ViewRecord
{
    protected static string $resource = FsrPartResource::class;
    protected static ?string $title = 'FSR Form';
    //  protected static string $view = 'filament.part.fsr-part-view';
}
