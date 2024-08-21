<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Filament\Resources\EquipmentResource\RelationManagers\ProjectEquipmentsRelationManager;
use App\Filament\Resources\EquipmentResource\RelationManagers\ProjectsRelationManager;
use App\Filament\Resources\FsrResource\RelationManagers\EquipmentsRelationManager;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

protected static ?string $navigationGroup = 'Equipments';

protected static ?string $label = 'Equipments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('brand')
                    ->nullable(),
                TextInput::make('model')
                    ->nullable(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->nullable(),
                TextInput::make('serial')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Equipments on Site')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->striped()
            ->columns([
                TextColumn::make('fsrs.fsr_no')
                    ->label('FSR')
                    ->default('No FSR Associated')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->badge(),
                TextColumn::make('brand')
                    ->searchable()
                    ->default('No Data'),
                TextColumn::make('model')
                    ->searchable()
                    ->default('No Data'),
                TextColumn::make('serial')
                    ->searchable()
                    ->default('No Data'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    // Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProjectsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
