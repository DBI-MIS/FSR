<?php

namespace App\Filament\Resources\FsrResource\RelationManagers;

use App\Filament\Resources\FsrEquipReplaceResource;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReplacementsRelationManager extends RelationManager
{
    protected static string $relationship = 'replacements';
    protected static ?string $title = 'Replacements for Equipments/Parts';

    public function form(Form $form): Form
    {
        return FsrEquipReplaceResource::form($form);
    //     return $form
    //         ->schema([
    //         TextInput::make('brand')
    //             ->nullable(),
    //         TextInput::make('model')
    //             ->nullable(),
    //         Textarea::make('part_description')
    //             ->nullable(),
    //         Textarea::make('part_no')
    //             ->nullable(),
    //         TextInput::make('part_quantity')
    //             ->numeric()
    //             ->nullable(),
    //         ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('model')
            ->columns([
                TextColumn::make('brand')
                ->searchable(),
            TextColumn::make('model')
                ->searchable(),
            TextColumn::make('part_quantity')
                ->numeric()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->recordSelect(
                    fn (Select $select) => $select->placeholder('Search for Model or Part No.'),
                )
                ->multiple()
                ->preloadRecordSelect()
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Forms\Components\TextInput::make('order')->numeric()->required(),
                ])
                ->recordSelectSearchColumns(['model', 'part_no',])
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
