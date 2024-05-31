<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFsr extends EditRecord
{
    protected static string $resource = FsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

//     public function hasCombinedRelationManagerTabsWithContent(): bool
// {
//     return true;
// }
}
