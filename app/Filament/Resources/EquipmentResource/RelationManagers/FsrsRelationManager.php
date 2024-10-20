<?php

namespace App\Filament\Resources\EquipmentResource\RelationManagers;

use App\Filament\Resources\FsrResource;
use App\Models\Fsr;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FsrsRelationManager extends RelationManager
{
    protected static string $relationship = 'fsrs';

    protected static ?string $title = 'FSR No.';

    public function form(Form $form): Form
    {
        return FsrResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fsr_no')
            ->columns([
                Tables\Columns\TextColumn::make('fsr_no')
                ->label('FSR No.'),
            ])
            ->inverseRelationship('equipments')
            ->filters([
                //
            ])
            ->headerActions([
                 // Tables\Actions\CreateAction::make(),
                 Tables\Actions\AttachAction::make()
                 ->preloadRecordSelect()
                     ->multiple(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
