<?php

namespace App\Filament\Resources\FsrResource\RelationManagers;

use App\Filament\Resources\DbePersonnelResource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonnelsRelationManager extends RelationManager
{
    protected static string $relationship = 'personnels';
    protected static ?string $title = 'DBE Personnels';

    public function form(Form $form): Form
    {

        return DbePersonnelResource::form($form);
        // return $form
        //     ->schema([
        //         TextInput::make('name')
        //             ->required(),
        //         TextInput::make('designation')->nullable(),
        //         ToggleButtons::make('employee_status')->inline()
        //         ->options([
        //             'Active' => 'Active',
        //             'Inactive' => 'Inactive',
        //             'Resigned' => 'Resigned',
        //         ])
        //         ->colors([
        //             'Active' => 'success',
        //             'Inactive' => 'info',
        //             'Resigned' => 'warning',
        //         ])
        //         ->nullable(),
        //         TextInput::make('order')
        //             ->numeric(),
        //     ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->heading('DBE Personnels')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('designation'),
                TextColumn::make('employee_status')
                ->badge()
                ->label('Status')
                ->sortable(),
                TextColumn::make('order')
                ->hidden()
                ->numeric()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->preloadRecordSelect()
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Forms\Components\TextInput::make('order')->numeric()->required(),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),
        
                ]),
            ]);
    }
}
