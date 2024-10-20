<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Pages\ViewEquipments;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\EquipmentProjectsRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\FsrsRelationManager;
use App\Models\Equipment;
use App\Models\Project;
use App\Models\User;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\GlobalSearch\Actions\Action;
use Filament\Infolists\Components\View;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
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

protected static ?string $recordTitleAttribute = 'name';

public static function getGloballySearchableAttributes(): array
{
    return ['name', 'address',];
}

public static function getGlobalSearchResultDetails(Model $record): array
{
    return [
        'Project' => $record->name,
        'Address' => $record->address,
    ];
}

public static function getGlobalSearchResultUrl(Model $record): string
{
    return ProjectResource::getUrl('view', ['record' => $record]);
}

public static function getGlobalSearchResultActions(Model $record): array
{
    return [
        Action::make('edit')
            ->url(static::getUrl('edit', ['record' => $record])),
    ];
}


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
            ->defaultPaginationPageOption(27)
            ->recordUrl(null)
            ->deferLoading()
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                // TextColumn::make('id')->sortable()
                // ->default('No Data'),
                // TextColumn::make('name')->searchable()
                // ->default('No Data')
                // ->searchable(),
                // TextColumn::make('address')
                // ->default('No Data'),

                LayoutView::make('filament.table.project-row-content'),
                
            ])
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->filters([

                Filter::make('Project')
                        ->form([
                            TextInput::make('name')->label('Project/Client')
                                ->helperText('Search Project/Client only'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            if (!empty($data['name'])) {
                                $projectName = $data['name'];
                                $query->where('name', 'like', '%' . $projectName . '%');
                            }

                            return $query;
                        }),

                        SelectFilter::make('warranty')
                        ->label('Warranty')
                        ->options([
                            'Under Warranty' => 'Under Warranty',
                            'Out of Warranty' => 'Out of Warranty',
                            'In House' => 'In House',
                        ])
                        ->multiple(),

                        Filter::make('Address')
                        ->form([
                            TextInput::make('address')->label('Address')
                                ->helperText('Search Address only'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            if (!empty($data['address'])) {
                                $projectAddress = $data['address'];
                                $query->where('address', 'like', '%' . $projectAddress . '%');
                            }

                            return $query;
                        }),
            ],
            layout: FiltersLayout::AboveContent
            )
            ->actions([
              
                Tables\Actions\EditAction::make()
                ->label(' ')
                ->tooltip('Edit'),
                Tables\Actions\ViewAction::make()
                ->label(' ')
                ->icon('heroicon-o-presentation-chart-line')
                ->tooltip('Timeline'),
                Tables\Actions\Action::make('view')
                ->label(' ')
                ->tooltip('Equipment')
                ->icon('heroicon-o-archive-box-arrow-down')
                ->url(fn (Project $record): string => route('filament.admin.resources.projects.equipments', $record->id)),
                Tables\Actions\Action::make('view')
                ->label(' ')
                ->tooltip('History')
                ->icon('heroicon-o-clock')
                ->url(fn (Project $record): string => route('filament.admin.resources.projects.history', $record->id))
           
            ],position: ActionsPosition::BeforeCells)
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
            FsrsRelationManager::class,
            
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
            'history' => Pages\ViewHistory::route('/{record}/history'),
            
        ];
    }
}
