<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FsrEquipReplaceResource\Pages;
use App\Filament\Resources\FsrEquipReplaceResource\RelationManagers;
use App\Filament\Resources\FsrEquipReplaceResource\RelationManagers\FsrsRelationManager;
use App\Models\FsrEquipReplace;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FsrEquipReplaceResource extends Resource
{
    protected static ?string $model = FsrEquipReplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-x-mark';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Equipments';

    protected static ?string $label = 'Replacement';

    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                GazeBanner::make()
                ->lock()
                ->canTakeControl()
                ->hideOnCreate()
                ->columnSpanFull(),
                TextInput::make('brand')
                    ->nullable(),
                TextInput::make('model')
                    ->nullable(),
                Textarea::make('part_description')
                    ->nullable(),
                Textarea::make('part_no')
                    ->nullable(),
                TextInput::make('part_quantity')
                    ->numeric()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Equipments to be replace')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
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
                TextColumn::make('part_quantity')
                    ->numeric()
                    ->sortable()
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
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FsrsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFsrEquipReplaces::route('/'),
            'create' => Pages\CreateFsrEquipReplace::route('/create'),
            'edit' => Pages\EditFsrEquipReplace::route('/{record}/edit'),
        ];
    }
}
