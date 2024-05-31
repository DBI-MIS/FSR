<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\EquipmentProjectsRelationManager;
use App\Models\Equipment;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

protected static ?string $navigationParentItem = 'Fsrs';

protected static ?string $navigationGroup = 'FSR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->autocapitalize('words'),
                ToggleButtons::make('warranty')->inline()
                ->options([
                    'Under Warranty' => 'Under Warranty',
                    'Out of Warranty' => 'Out of Warranty',
                    'In House' => 'In House',
                ])
                ->colors([
                    'Under Warranty' => 'success',
                    'Out of Warranty' => 'warning',
                    'In House' => 'info',
                ]),
                TextInput::make('address'),

            ])->columns('1');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Projects / Clients')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->columns([
                TextColumn::make('id')->sortable()
                ->default('No Data'),
                TextColumn::make('name')->searchable()
                ->default('No Data'),
                TextColumn::make('address')
                ->default('No Data'),
                TextColumn::make('warranty')
                ->default('No Data')
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'Under Warranty' => 'success',
                'Out of Warranty' => 'warning',
                'In House' => 'info',
    })
            ])
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            EquipmentProjectsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
