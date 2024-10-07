<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Resources\FsrResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FsrsRelationManager extends RelationManager
{
    protected static string $relationship = 'fsrs';

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
            ->inverseRelationship('project')
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make(),
                // Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                // Tables\Actions\DetachAction::make(),
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }
}
