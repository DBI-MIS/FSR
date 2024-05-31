<?php

namespace App\Filament\Resources\FsrEquipReplaceResource\RelationManagers;

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

    public function form(Form $form): Form
    {
        return FsrResource::form($form);
        // return $form
        //     ->schema([
        //         Forms\Components\TextInput::make('fsr_no')
        //             ->required(),
        //     ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fsr_no')
            ->columns([
                Tables\Columns\TextColumn::make('fsr_no'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\AttachAction::make()
                // ->multiple()
                // ->preloadRecordSelect()
                // ->form(fn (AttachAction $action): array => [
                //     $action->getRecordSelect(),
                //     Forms\Components\TextInput::make('order')->numeric()->required(),
                // ])
                // ->recordSelectSearchColumns(['fsr_no',])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
