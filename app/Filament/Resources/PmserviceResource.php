<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PmserviceResource\Pages;
use App\Filament\Resources\PmserviceResource\RelationManagers;
use App\Models\Pmservice;
use App\Models\Project;
use Carbon\Carbon;
use Closure;
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
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
                            ->label('Project/Client')
                            // ->unique(ignoreRecord: true),
                            ->rules([
                                fn(Get $get, string $operation): Closure => function (string $attribute, $value, Closure $fail) use ($get, $operation) {

                                    if ($operation !== 'edit' && $value) {
                                        $pmservice = Pmservice::where('project_id', $value)->first();

                                        if ($pmservice) {
                                            if ($pmservice->end_date >= now()) {
                                                $fail("Already have a contract.");
                                            }

                                            if ($pmservice->subscription === 'continuous') {
                                                $fail("Already have a continuous contract.");
                                            }
                                        }
                                    }
                                },
                            ]),
                        Select::make('contract_type')
                            ->default('new')
                            ->label('Contract')
                            ->options([
                                'new' => 'New',
                                'renewal' => 'Renewal',
                            ])
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.contract_type" />')))
                            ->live(),

                        Select::make('status')
                            ->default('active')
                            ->options([
                                'active' => 'active',
                                'inactive' => 'inactive',
                                'cancelled' => 'cancelled',
                            ])
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.status" />')))
                            ->live(),



                        TextInput::make('po_ref')
                            ->label('P.O. Reference')
                            ->nullable(),




                    ])->columnSpan(1),

                Section::make('PM Schedule')
                    ->description(' ')
                    ->schema([

                        Select::make('contract_duration')
                            ->label('Contract Period')
                            ->options([
                                '1 Year' => '1 Year',
                                '2 Years' => '2 Years',
                                '3 Years' => '3 Years',
                                'Continuous' => 'Continuous',
                            ])
                            ->live()
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.contract_duration" />')))
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if ($state === 'Continuous') {
                                    $set('subscription', 'continuous');
                                }

                                $startDate = $get('start_date') ?? $get('renewal_date');
                                $contractDuration = $get('contract_duration');

                                if ($startDate && $contractDuration) {
                                    if ($contractDuration === 'Continuous') {
                                        $set('end_date', null);
                                    } else {
                                        $years = (int) filter_var($contractDuration, FILTER_SANITIZE_NUMBER_INT);
                                        $endDate = \Carbon\Carbon::parse($startDate)->addYears($years)->format('Y/m/d');
                                        $set('end_date', $endDate);
                                    }
                                } else {
                                    $set('end_date', null);
                                }
                            }),

                        DatePicker::make('start_date')
                            ->label('Start Date')
                            // ->default(Carbon::now())
                            ->columnSpan(1)
                            ->native(false)
                            ->hidden(
                                fn($get) => $get('contract_type') === 'renewal'
                            )
                            ->dehydrated()
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.start_date" />')))
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $startDate = $get('start_date');
                                $contractDuration = $get('contract_duration');

                                if ($startDate && $contractDuration) {
                                    if ($contractDuration === 'Continuous') {
                                        $set('end_date', null);
                                    } else {
                                        $years = (int) filter_var($contractDuration, FILTER_SANITIZE_NUMBER_INT);
                                        $endDate = \Carbon\Carbon::parse($startDate)->addYears($years)->format('Y/m/d');
                                        $set('end_date', $endDate);
                                    }
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
                            )
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.renewal_date" />')))
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $startDate = $get('renewal_date');
                                $contractDuration = $get('contract_duration');

                                if ($startDate && $contractDuration) {
                                    if ($contractDuration === 'Continuous') {
                                        $set('end_date', null);
                                    } else {
                                        $years = (int) filter_var($contractDuration, FILTER_SANITIZE_NUMBER_INT);
                                        $endDate = \Carbon\Carbon::parse($startDate)->addYears($years)->format('Y/m/d');
                                        $set('end_date', $endDate);
                                    }
                                } else {
                                    $set('end_date', null);
                                }
                            }),




                        Select::make('subscription')
                            ->live()
                            ->options(fn(Get $get): array => match ($get('contract_duration')) {
                                '1 Year' => [
                                    'bimonthly' => 'bimonthly',
                                    'monthly' => 'monthly',
                                    'quarterly' => 'quarterly',
                                    'semi-annual' => 'semi-annual',
                                    'annual' => 'annual',
                                ],
                                '2 Years' => [
                                    'bimonthly' => 'bimonthly',
                                    'monthly' => 'monthly',
                                    'quarterly' => 'quarterly',
                                    'semi-annual' => 'semi-annual',
                                    'annual' => 'annual',
                                ],
                                '3 Years' => [
                                    'bimonthly' => 'bimonthly',
                                    'monthly' => 'monthly',
                                    'quarterly' => 'quarterly',
                                    'semi-annual' => 'semi-annual',
                                    'annual' => 'annual',
                                ],
                                'Continuous' => [
                                    'continuous' => 'continuous'
                                ],
                                default => [],
                            })

                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.subscription" />')))
                            ->afterStateUpdated(function ($state, $set) {
                                $validStates = [
                                    ['bimonthly' => 'bimonthly'],
                                    ['monthly' => 'monthly'],
                                    ['quarterly' => 'quarterly'],
                                    ['semi-annual' => 'semi-annual'],
                                    ['annual' => 'annual'],
                                    ['continuous' => 'continuous'],
                                ];

                                $validStateValues = array_map(fn($option) => array_values($option)[0], $validStates); // Extract the values from nested arrays

                                if (in_array($state, $validStateValues)) {
                                    $set('date_slots', [['type' => strtoupper($state)]]);
                                } else {
                                    $set('date_slots', []);
                                }
                            }),

                        DatePicker::make('end_date')
                            ->nullable()
                            ->label('End Date')
                            ->native(false)
                            ->after('start_date'),
                        // ->dehydrated()
                        // ->dehydrateStateUsing(function ($state, $get) {
                        //     $startDate = $get('start_date'); // Retrieve the state of 'start_date'
                        //     $contractDuration = $get('contract_duration'); // Retrieve the state of 'contract_duration'

                        //     if ($startDate && $contractDuration) {
                        //         return \Carbon\Carbon::parse($startDate)->addDays($contractDuration);
                        //     }

                        //     return $state; // Return the existing state if no changes are needed
                        // }),

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
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.subscription" />')))
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
                                        case 'CONTINUOUS':
                                            $set('subscription', 'continuous');
                                            break;
                                    }
                                }
                            })

                            ->blocks([
                                Builder\Block::make('BIMONTHLY')
                                    ->hidden(fn($get) => $get('../subscription') !== 'bimonthly')
                                    ->label(__('Bi-Monthly'))
                                    ->schema([
                                        Section::make('1st Month')
                                            ->schema([
                                                DatePicker::make('date_slot_01')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_01')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_01_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_01_')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed()
                                        // ->afterStateHydrated(function($get) {
                                        //     dd($get('./'));
                                        // })
                                        ,

                                        Section::make('2nd Month')
                                            ->schema([
                                                DatePicker::make('date_slot_02')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_02')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_02_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_02_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_03')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_03_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_03_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_04')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_04_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_04_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_05')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_05_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_05_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_06')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_06_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_06_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_07')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_07_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_07_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_08')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_08_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_08_')
                                                    ->label('Note')
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
                                                TextInput::make('note_slot_09')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_09_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_09_')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('10th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_010')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_010')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_010_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_010_')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('11th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_011')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_011')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_011_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_011_')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),

                                        Section::make('12th Month')
                                            ->schema([
                                                DatePicker::make('date_slot_012')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_012')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                                DatePicker::make('date_slot_012_')
                                                    ->label('Date')
                                                    ->columnSpan(1),
                                                TextInput::make('note_slot_012_')
                                                    ->label('Note')
                                                    ->columnSpan(1),
                                            ])
                                            ->columnSpan(1)
                                            ->compact()
                                            ->collapsible()
                                            ->persistCollapsed()
                                            ->collapsed(),


                                    ])->columns(4),

                                Builder\Block::make('MONTHLY')
                                    ->hidden(fn($get) => $get('../subscription') !== 'monthly')
                                    ->label(__('Monthly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_01')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_02')
                                            ->label('2nd Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_02')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_03')
                                            ->label('3rd Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_03')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_04')
                                            ->label('4th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_04')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_05')
                                            ->label('5th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_05')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_06')
                                            ->label('6th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_06')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('7th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_07')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_08')
                                            ->label('8th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_08')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_09')
                                            ->label('9th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_09')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_010')
                                            ->label('10th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_010')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_011')
                                            ->label('11th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_011')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_012')
                                            ->label('12th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_012')
                                            ->label('Note')
                                            ->columnSpan(1),

                                    ])->columns(4),

                                Builder\Block::make('QUARTERLY')
                                    ->hidden(fn($get) => $get('../subscription') !== 'quarterly')
                                    ->label(__('Quarterly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Quarter')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_01')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_04')
                                            ->label('2nd Quarter')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_04')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('3rd Quarter')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_07')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_010')
                                            ->label('4th Quarter')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_010')
                                            ->label('Note')
                                            ->columnSpan(1),
                                    ])->columns(4),

                                Builder\Block::make('SEMI-ANNUAL')
                                    ->hidden(fn($get) => $get('../subscription') !== 'semi-annual')
                                    ->label(__('Semi Annual'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Half')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_01')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('2nd Half')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_07')
                                            ->label('Note')
                                            ->columnSpan(1),
                                    ])->columns(2),

                                Builder\Block::make('ANNUAL')
                                    ->hidden(fn($get) => $get('../subscription') !== 'annual')
                                    ->label(__('Yearly'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('Date')
                                            ->columnSpanFull(),
                                        TextInput::make('note_slot_01')
                                            ->label('Note')
                                            ->columnSpan(1),
                                    ]),
                                Builder\Block::make('CONTINUOUS')
                                    ->hidden(fn($get) => $get('../subscription') !== 'continuous')
                                    ->label(__('Continuous'))
                                    ->schema([
                                        DatePicker::make('date_slot_01')
                                            ->label('1st Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_01')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_02')
                                            ->label('2nd Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_02')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_03')
                                            ->label('3rd Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_03')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_04')
                                            ->label('4th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_04')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_05')
                                            ->label('5th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_05')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_06')
                                            ->label('6th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_06')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_07')
                                            ->label('7th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_07')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_08')
                                            ->label('8th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_08')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_09')
                                            ->label('9th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_09')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_010')
                                            ->label('10th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_010')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_011')
                                            ->label('11th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_011')
                                            ->label('Note')
                                            ->columnSpan(1),
                                        DatePicker::make('date_slot_012')
                                            ->label('12th Month')
                                            ->columnSpan(1),
                                        TextInput::make('note_slot_012')
                                            ->label('Note')
                                            ->columnSpan(1),

                                    ])->columns(4),
                            ])
                            ->columnSpanFull()
                            ->blockPickerColumns(1)
                            ->minItems(1)
                            ->maxItems(function ($get) {
                                $contract = $get('contract_duration');

                                switch ($contract) {
                                    case 'Continuous':
                                        return PHP_INT_MAX;
                                    case '1 Year':
                                        return 1;
                                    case '2 Years':
                                        return 2;
                                    case '3 Years':
                                        return 3;
                                    default:
                                        return 1; // Default value if no match
                                }
                            })

                            ->blockNumbers(false)
                            ->reorderable(false)
                            ->addActionLabel('Add')
                            ->deletable(fn(string $operation): bool => $operation !== 'edit' || auth()->user()->role === 'ADMIN'),

                    ])
                    ->columns(2)
                    ->columnSpan(2),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('subscription')
                    ->label('Subscription'),
                Group::make('contract_duration')
                    ->label('Contract'),
            ])
            ->defaultGroup('subscription')
            ->heading('PM List')
            // ->description('Click the funnel to filter the list.')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->recordUrl(null)
            ->striped()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            // ->modifyQueryUsing(function (EloquentBuilder $query) {
            //     $subQuery = DB::table('pmservices as sub')
            //         ->select('project_id', DB::raw('MAX(COALESCE(renewal_date, start_date)) as latest_date'))
            //         ->groupBy('project_id');

            //     return $query
            //         ->joinSub($subQuery, 'latest', function ($join) {
            //             $join->on('pmservices.project_id', '=', 'latest.project_id')
            //                 ->on('pmservices.start_date', '=', 'latest.latest_date')
            //                 ->orOn('pmservices.renewal_date', '=', 'latest.latest_date');
            //         })
            //         ->orderBy('end_date', 'desc');
            // })

            ->columns([
                TextColumn::make('pm_project.name')
                    ->label('Project/Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contract_type')
                    ->label('Type')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'success',
                        'renewal' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'info',
                        'cancelled' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contract_duration')
                    ->label('Period')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('subscription')
                    ->label('Frequency')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'bimonthly' => 'success',
                        'monthly' => 'success',
                        'quarterly' => 'warning',
                        'semi-annual' => 'warning',
                        'annual' => 'warning',
                        'continuous' => 'danger',
                    })
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('renewal_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ViewColumn::make('dates_slots')->view('filament.table.pm-row-content')
                    ->label('PM Served'),


            ])
            ->filters([
                SelectFilter::make('status')
                    // ->default('active')
                    ->options([
                        'active' => 'active',
                        'inactive' => 'inactive',
                        'cancelled' => 'cancelled',
                    ]),
                SelectFilter::make('contract_type')
                    ->label('Contract')
                    ->options([
                        'new' => 'New',
                        'renewal' => 'Renewal',
                    ]),

                    TrashedFilter::make()
                    ->hidden(auth()->user()->role !== 'ADMIN'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(' '),
                Tables\Actions\ForceDeleteAction::make()
                ->hidden(auth()->user()->role !== 'ADMIN'),
                Tables\Actions\RestoreAction::make()
                ->hidden(auth()->user()->role !== 'ADMIN'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make()
                    ->hidden(auth()->user()->role !== 'ADMIN'),
                    Tables\Actions\RestoreBulkAction::make()
                    ->hidden(auth()->user()->role !== 'ADMIN'),
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
