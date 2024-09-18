<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DbeDirectoryResource\Pages;
use App\Filament\Resources\DbeDirectoryResource\RelationManagers;
use App\Models\Contact;
use App\Models\DbeDirectory;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Infolists\Components\Component;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\View;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DbeDirectoryResource extends Resource
{
    protected static ?string $model = DbeDirectory::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $label = 'Client';

    protected static ?int $navigationSort = 1;

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'directoryproject.name',
            'contactsdbe.contact_person',
            'contactsdbe.contact_no',
            'contactsdbe.email_address',
            'contactsdbe.designation',
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['contactsdbe', 'directoryproject']);
    }




    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Directory';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Section::make()->schema([
                    Select::make('project_id')
                        ->live()
                        ->label('Project/Client')
                        ->relationship('directoryproject', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm([
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
                            Textarea::make('address')->rows(5),
                        ])->createOptionModalHeading('Create New Project'),

                    TextInput::make('status')
                        ->label('Status')
                        ->default('inactive')
                        ->disabled(),

                ])->columnSpan(2),
                Section::make('CONTACT DETAILS')->schema([
                    Repeater::make('contact_id')
                        ->label('Contact Information')
                        ->relationship('contactsdbe')
                        ->schema([
                            Split::make([
                                Section::make()->schema([
                                    TextInput::make('contact_person')
                                        ->prefixIcon('heroicon-m-user-circle')
                                        ->label('Contact Name')
                                        ->columnSpanFull(),
                                    TextInput::make('email_address')
                                        ->prefixIcon('heroicon-m-envelope')
                                        ->email()
                                        ->label('Email Address')
                                        ->nullable()
                                        ->columnSpanFull(),
                                    TextInput::make('designation')
                                        ->prefixIcon('heroicon-m-briefcase')
                                        ->label('Designation')
                                        ->nullable()
                                        ->columnSpanFull(),
                                ])->columnSpan(2),

                                Repeater::make('contact_no')
                                    ->label('Contact No.')
                                    ->hint('Use "loc" for local')
                                    ->schema([
                                        TextInput::make('contact_no')
                                            ->prefixIcon('heroicon-m-phone')
                                            ->nullable()
                                            ->tel()
                                            // ->telRegex('/^(\+63\s?\d{1,2}[\s-]?\d{3}[\s-]?\d{4}(\s+loc\s+\d{0,5})?|\+639\d{9}|\d{11}|\d{3}[\s-]?\d{4}(\s+loc\s+\d{0,5})?)$/')
                                            // ->telRegex('/^(\+\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,5})?|\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,5})?)$/')
                                            // ->telRegex('/^(\+\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,6})?|\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,6})?|\d{7}\s+loc\s+\d{3}(\s+to\s+\d{3})?)$/')
                                            // ->telRegex('/^(\+\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,6}(\s+to\s+\d{1,6})?)?|\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,6}(\s+to\s+\d{1,6})?)?|\d{7}\s+loc\s+\d{3}(\s+to\s+\d{3})?)$/')
                                            ->telRegex('/^(\+\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,9}(\s+loc\s+\d{0,6}(\s+to\s+\d{1,6})?)?|\d{1,4}[\s-]?\d{1,9}(\s+to\s+\d{1,9})?(\s+loc\s+\d{0,6}(\s+to\s+\d{1,6})?)?|\d{7}\s+loc\s+\d{3}(\s+to\s+\d{3})?)$/')
                                            ->label(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? 'Edit Phone Number' : 'Add No.'),
                                    ])
                                    ->required()
                                    ->minItems(1)
                                    ->collapsed()
                                    ->itemLabel(fn(array $state): ?string => $state['contact_no'] ?? null)
                                    ->addActionLabel('+ Another Phone Number')
                                    ->columnSpan(2),

                            ])->columnSpan(4)
                        ])
                        ->columnSpan(4)
                        ->minItems(1)
                        ->addActionLabel('+ Another Contact'),

                ])->columnSpan(4)
            ])->columns(6);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            // ->searchable()
            ->emptyStateHeading('No Record')
            // ->defaultSort('status', 'desc')
            ->defaultPaginationPageOption(25)
            ->striped()
            ->columns([
                LayoutView::make('filament.table.dbe-directory')

            ])
            ->contentGrid([
                // 'default' => 3,
                'lg' => 1,
            ])

            // ->columns([
            //     TextColumn::make('project.name')  
            //     ->label('Project/Client')  
            //     ->sortable()
            //     ->searchable(),
            //     TextColumn::make('contact_no')
            //     ->label('Contact No.')
            //         ->sortable(),
            //     TextColumn::make('contact_person')
            //     ->label('Contact Person')
            //         ->searchable()
            //         ->sortable(),
            //     TextColumn::make('designation')
            //     ->label('Designation')
            //         ->searchable()
            //         ->sortable(),
            //     TextColumn::make('email_address')
            //     ->label('Email')
            //         ->sortable(),
            //     TextColumn::make('created_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            //     TextColumn::make('updated_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            // ])
            ->filters(
                [
                    Filter::make('contactsdbe')
                        ->form([
                            TextInput::make('search')->label('Search')
                                ->helperText(' '),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            if (!empty($data['search'])) {
                                $searchTerm = $data['search'];

                                return $query->whereHas('contactsdbe', function ($subQuery) use ($searchTerm) {
                                    $subQuery->where('contact_no', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('contact_person', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('email_address', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('designation', 'like', '%' . $searchTerm . '%');
                                });
                            }

                            return $query;
                        }),


                    SelectFilter::make('project_id')

                        ->label('Project Name /Client Name')
                        ->relationship('directoryproject', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),

                    SelectFilter::make('status')
                        ->options([
                            'active' => 'active',
                            'inactive' => 'inactive',
                        ]),



                    // Filter::make('directoryproject.name')
                    // ->label('Project Name')
                    // ->query(function ($query, $value) {
                    //     return $query->whereHas('directoryproject', function ($query) use ($value) {
                    //         $query->where('name', 'like', "%{$value}%");
                    //     });
                    // }),
                    // Filter::make('project')
                    // ->form([
                    //     TextInput::make('fsr_no')->label('FSR No.')
                    //         ->helperText('Search FSR No. only'),
                    // ])
                    // ->query(function (Builder $query, array $data): Builder {
                    //     if (!empty($data['fsr_no'])) {
                    //         $fsrNo = $data['fsr_no'];
                    //         return $query->where('fsr_no', 'like', '%' . $fsrNo . '%');
                    //     }
                    //     return $query;
                    // }),


                ], // layout: FiltersLayout::AboveContentCollapsible)
                layout: FiltersLayout::AboveContent
            )
            ->filtersFormColumns(3)
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                View::make('infolists.components.view-dbe-directory')->columnSpanFull(),

            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['directoryproject.relatedfsrs']);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDbeDirectories::route('/'),
            'create' => Pages\CreateDbeDirectory::route('/create'),
            'edit' => Pages\EditDbeDirectory::route('/{record}/edit'),
            'view' => Pages\ViewDbeDirectory::route('/{record}'),
        ];
    }
}
