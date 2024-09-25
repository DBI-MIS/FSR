<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PmserviceResource\Pages;
use App\Filament\Resources\PmserviceResource\RelationManagers;
use App\Models\Pmservice;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;

use function Laravel\Prompts\form;

class PmserviceResource extends Resource
{
    protected static ?string $model = Pmservice::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'FSR';

    protected static ?string $label = 'PM Service';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Project')
                    ->description(' ')
                    ->schema([
                    Select::make('project_id')
                        ->relationship('pm_project', 'name')
                        ->searchable()
                        ->label('Project/Client'),
                        Select::make('contract_type')
                            ->default('new')
                            ->label('Contract')
                            ->options([
                                'new' => 'New',
                                'renewal' => 'Renewal',
                            ])
                            ->live(),
                      
                        Select::make('status')
                            ->default('active')
                            ->options([
                                'active' => 'active',
                                'inactive' => 'inactive',
                                'cancelled' => 'cancelled',
                            ])
                            ->live(),


                       
                        TextInput::make('po_ref')
                            ->label('P.O. Reference')
                            ->nullable(),




                    ])->columnSpan(1),

                Section::make('PM Schedule')
                    ->description(' ')
                    ->schema([
                      
                            Select::make('contract_duration')
                            ->default('1 Year')
                            ->label('Contract Period')
                            ->options([
                                '1 Year' => '1 Year',
                                '2 Years' => '2 Years',
                                '3 Years' => '3 Years',
                            ])
                            ->live(),

                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(Carbon::now())
                            ->columnSpan(1)
                            ->native(false)
                            ->hidden(
                                fn($get) => $get('contract_type') === 'renewal'
                            )
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $startDate = $get('start_date');
                                $contractDuration = $get('contract_duration');
                        
                                if ($startDate && $contractDuration) {
                                    $years = (int) filter_var($contractDuration, FILTER_SANITIZE_NUMBER_INT);
                                    $endDate = \Carbon\Carbon::parse($startDate)->addYears($years)->format('Y/m/d');
                        
                                    $set('end_date', $endDate);
                                } else {
                                    $set('end_date', null);
                                }
                            }),
                            
                               
                        
                        DatePicker::make('renewal_date')
                            ->label('Renewal Date')
                            ->native(false)
                            ->columnSpan(1)
                            ->visible(
                                fn($get) => $get('contract_type') === 'renewal'
                            ),

                            DatePicker::make('end_date')
                            ->native(false)
                            ->displayFormat('Y/m/d')
                            ->disabled(),
                            

                            Select::make('subscription')
                            ->options([
                                'bimonthly' => 'bimonthly',
                                'monthly' => 'monthly',
                                'quarterly' => 'quarterly',
                                'semi-annual' => 'semi-annual',
                                'annual' => 'annual',
                                'custom' => 'custom',
                            ])
                            ->default('Select Subscription on the right panel')
                            ->disabled(),

                            TextInput::make('free_tc')
                            ->label('Free Trouble Call')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Repeater::make('equipment')
                            ->label('Equipment Coverage')
                            ->schema([
                                TextInput::make('CH')
                                    ->label('')
                                    ->prefix('CH')
                                    ->columnSpan(1)
                                    ->default(0)
                                    ->numeric(),
                                TextInput::make('CT')
                                    ->label('')
                                    ->prefix('CT')
                                    ->columnSpan(1)
                                    ->default(0)
                                    ->numeric(),
                                TextInput::make('AHU')
                                    ->label('')
                                    ->prefix('AHU')
                                    ->default(0)
                                    ->numeric(),
                                TextInput::make('ACU')
                                    ->label('')
                                    ->prefix('ACU')
                                    ->default(0)
                                    ->numeric(),
                            ])
                            ->defaultItems(1)
                            ->columns(4)
                            ->columnSpan(2)
                            ->addable(false)
                            ->reorderable(false)
                            ->deletable(false),

                        Builder::make('date_slots')
                            ->label('Preventive Maintenance Subscription')
                            ->live()
                            ->afterStateUpdated(function ($get, $set) {
                                $dateSlots = $get('date_slots');
                                if (!empty($dateSlots)) {
                                    $firstSlot = array_values($dateSlots)[0];
                                    $type = $firstSlot['type'];

                                    switch ($type) {
                                        case 'BIMONTHLY':
                                            $set('subscription', 'bimonthly');
                                            break;
                                        case 'MONTHLY':
                                            $set('subscription', 'monthly');
                                            break;
                                        case 'QUARTERLY':
                                            $set('subscription', 'quarterly');
                                            break;
                                        case 'SEMI-ANNUAL':
                                            $set('subscription', 'semi-annual');
                                            break;
                                        case 'ANNUAL':
                                            $set('subscription', 'annual');
                                            break;
                                        case 'CUSTOM':
                                            $set('subscription', 'monthly');
                                            break;
                                        default:
                                            $set('subscription', 'Select Subscription on the right panel');
                                            break;
                                    }
                                } else {
                                    $set('subscription', 'Select Subscription on the right panel');
                                }
                            })

                            ->blocks([
                                Builder\Block::make('BIMONTHLY')

                                    ->label(__('Bi-Monthly'))
                                    ->schema([
                                        Section::make('1st Month')
                                            ->schema([
                                                DatePicker::make('date_slot_01')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_01_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('2nd Month')
                                            ->schema([
                                                DatePicker::make('date_slot_02')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_02_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('3rd Month')
                                            ->schema([
                                                DatePicker::make('date_slot_03')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_03_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('4th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_04')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_04_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('5th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_05')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_05_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('6th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_06')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_06_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('7th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_07')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_07_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('8th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_08')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_08_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('9th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_09')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_09_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('10th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_10')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_10_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('11th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_11')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_11_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('12th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_12')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_12_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),


                                    ])->columns(4),

                                Builder\Block::make('MONTHLY')
                                    ->label(__('Monthly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_02')
                                            ->label('2nd Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_03')
                                            ->label('3rd Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_04')
                                            ->label('4th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_05')
                                            ->label('5th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_06')
                                            ->label('6th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('7th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_08')
                                            ->label('8th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_09')
                                            ->label('9th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_10')
                                            ->label('10th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_11')
                                            ->label('11th Month')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_12')
                                            ->label('12th Month')
                                            ->columnSpan(1),

                                    ])->columns(4),

                                Builder\Block::make('QUARTERLY')
                                    ->label(__('Quarterly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Quarter')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_04')
                                            ->label('2nd Quarter')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('3rd Quarter')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_10')
                                            ->label('4th Quarter')
                                            ->columnSpan(1),
                                    ])->columns(4),

                                Builder\Block::make('SEMI-ANNUAL')
                                    ->label(__('Semi Annual'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Half')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('2nd Half')
                                            ->columnSpan(1),
                                    ])->columns(2),

                                Builder\Block::make('ANNUAL')
                                    ->label(__('Yearly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('Date')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpanFull()
                            ->blockPickerColumns(2)
                            ->minItems(1)
                            ->maxItems(1)
                            ->blockNumbers(false)
                            ->reorderable(false)
                            ->addActionLabel('Add Subscription')
                            ->deletable(fn(string $operation): bool => $operation !== 'edit' || auth()->user()->role === 'ADMIN'),

                    ])
                    ->columns(2)
                    ->columnSpan(2),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pm_project.name')
                    ->label('Project/Client')
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_type')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'success',
                        'renewal' => 'warning',
                        
                    }),
                Tables\Columns\TextColumn::make('contract_duration')
                    ->label('Contract Period')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subscription')
                    ->label('Freq')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('renewal_date')
                    ->date()
                    ->sortable(),
            ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPmservices::route('/'),
            'create' => Pages\CreatePmservice::route('/create'),
            'edit' => Pages\EditPmservice::route('/{record}/edit'),
        ];
    }
}
