<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FsrEquipReplaceResource\RelationManagers\FsrsRelationManager;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Pages\ViewEquipments;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\EquipmentProjectsRelationManager;
use App\Models\Equipment;
use App\Models\Project;
use App\Models\User;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Infolists\Components\View;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}


protected static ?string $navigationGroup = 'Projects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                GazeBanner::make()
                ->lock()
                ->canTakeControl()
                ->hideOnCreate()
                ->columnSpanFull(),
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
                Tables\Actions\ViewAction::make()->label('Timeline'),
                Tables\Actions\Action::make('view')
                ->label('Equipments')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->url(fn (Project $record): string => route('filament.admin.resources.projects.equipments', $record->id))
                // ->url(fn (Project $record): string => route('filament.part.project-equipment-view', $record->id)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


   
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                View::make('filament.part.project-view')
                ->columnSpan(3),
                CommentsEntry::make('project_comments')
                ->columnSpan(1),
            ])->columns(4);

    }


    
    public static function getRelations(): array
    {
        return [
            // EquipmentProjectsRelationManager::class,
            // FsrsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewProject::route('/{record}'),
            'equipments' => Pages\ViewEquipments::route('/{record}/equipments'),
            
        ];
    }
}
