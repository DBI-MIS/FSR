<?php

namespace App\Filament\Resources\FsrEquipReplaceResource\Pages;

use App\Filament\Resources\FsrEquipReplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFsrEquipReplace extends EditRecord
{
    protected static string $resource = FsrEquipReplaceResource::class;

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

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
