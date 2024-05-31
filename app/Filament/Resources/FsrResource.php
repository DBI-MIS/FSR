<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FsrResource\Pages;
use App\Filament\Resources\FsrResource\RelationManagers;
use App\Filament\Resources\FsrResource\RelationManagers\EquipmentsRelationManager;
use App\Filament\Resources\FsrResource\RelationManagers\PersonnelsRelationManager;
use App\Filament\Resources\FsrResource\RelationManagers\ReplacementsRelationManager;
use App\Models\DbePersonnel;
use App\Models\Equipment;
use App\Models\Fsr;
use App\Models\Project;
use App\Models\Rating;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split as LayoutSplit;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Actions\RatingStar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;
use IbrahimBougaoua\FilamentRatingStar\Columns\RatingStarColumn;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Collection;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class FsrResource extends Resource
{
    protected static ?string $model = Fsr::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

protected static ?string $navigationGroup = 'FSR';

    use CreateRecord\Concerns\HasWizard;

    // protected function getSteps(): array
    // {

    // public static function canCreate(): bool
    //    {
    //       return false;
    //    }    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
//////////////////////////////////////////////////////////////////////////////////            
                    Step::make('FSR Details')
                        ->description(' ')
                        ->columns(4)
                        ->schema([

                            TextInput::make('fsr_no')
                                ->label('FSR No.')
                                ->unique(ignoreRecord: true)
                                ->disabledOn('edit'),

                            Select::make('project_id')
                                ->live()
                                ->label('Project/Client')
                                ->relationship('project', 'name')
                                ->searchable()
                                ->columnSpan(2)
                                ->preload()
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
                                    TextArea::make('address')->rows(5),
                                ])->createOptionModalHeading('Create New Project'),

                            Select::make('personnels')
                                ->multiple()
                                ->nullable()
                                ->relationship('personnels', 'name')
                                ->searchable()
                                ->preload(),

                            DatePicker::make('job_date_started')
                                ->label('Date Started')
                                ->nullable(),
                            TimePicker::make('time_arrived')
                                ->label('Time Arrived')
                                ->nullable(),
                            DatePicker::make('job_date_finished')
                                ->label('Date Finished')
                                ->nullable(),
                            TimePicker::make('time_completed')
                                ->label('Time Completed')
                                ->nullable(),
                            
                            

                            Select::make('attended_to')
                                ->options([
                                    'Preventive Maintenance' => 'Preventive Maintenance',
                                    'Trouble Call' => 'Trouble Call',
                                    'Check Up' => 'Check-up',
                                    'Evaluation' => 'Evaluation',
                                    'Start Up' => 'Start Up',
                                    'Testing' => 'Testing',
                                    'Commissioning' => 'Commissioning',
                                    'Monitoring' => 'Monitoring',
                                    'Site Inspection' => 'Site Inspection',
                                    'Operatorship' => 'Operatorship',
                                    'Parts/Installation' => 'Parts/Installation',
                                    'Repair/Modification' => 'Repair/Modification',
                                    'Hauling' => 'Hauling',
                                    'Delivery' => 'Delivery',
                                    'Others' => 'Others',
                                ])
                                ->multiple()
                                ->columnSpan(4)
                                ->nullable(),

                            MarkdownEditor::make('concerns')
                                ->columnSpan(4)
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ]),

                        ]),
//////////////////////////////////////////////////////////////////////////////////////////////////
                    Step::make('Equipment')
                        ->description('Status')
                        ->columns(4)
                        ->schema([
                            Select::make('equipments')
                            ->columnSpan(4)
                            ->multiple()
                            ->nullable()
                            ->relationship('equipments', 'model')
                            ->searchable()
                            ->preload()
                            
                                ->createOptionForm([
                                    TextInput::make('brand')
                                    ->nullable(),
                                    TextInput::make('model')
                                    ->required(),
                                    TextInput::make('serial')
                                    ->nullable(),
                                    Textarea::make('description')
                                        ->columnSpanFull()
                                        ->nullable()
                                        ->rows(3),
                                ])->createOptionModalHeading('Create New Equipment'),

                            Fieldset::make('Voltage')
                                ->columns(3)
                                ->schema([
                                    TextInput::make('actual_voltage_v1')->nullable()
                                        ->prefix('L1')
                                        ->suffix('V')
                                        ->label(' '),
                                    TextInput::make('actual_voltage_v2')->nullable()
                                        ->prefix('L2')
                                        ->suffix('V')
                                        ->label(' '),
                                    TextInput::make('actual_voltage_v3')->nullable()
                                        ->prefix('L3')
                                        ->suffix('V')
                                        ->label(' '),
                                ])->columnSpan(2),

                            Fieldset::make('Amperage')
                                ->columns(3)
                                ->schema([
                                    TextInput::make('actual_amperage_v1')->nullable()
                                        ->prefix('L1')
                                        ->suffix('A')
                                        ->label(' '),
                                    TextInput::make('actual_amperage_v2')->nullable()
                                        ->prefix('L2')
                                        ->suffix('A')
                                        ->label(' '),
                                    TextInput::make('actual_amperage_v3')->nullable()
                                        ->prefix('L3')
                                        ->suffix('A')
                                        ->label(' '),
                                ])->columnSpan(2),
                                Fieldset::make(' ')
                                ->columns(3)
                                ->schema([
                            TextInput::make('voltage_imbalance')->nullable(),
                            TextInput::make('current_imbalance')->nullable(),
                            TextInput::make('control_voltage')->nullable(),
                            ])->columnSpan(4),
                            MarkdownEditor::make('service_rendered')
                                ->nullable()
                                ->columnSpan(4)
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ]),

                        ]),
////////////////////////////////////////////////////////////////////////////////////////////////////////
                    Step::make('Log Readings-1')
                        ->description(' ')
                        ->schema([

                            Fieldset::make('For')
                                ->columns(3)
                                ->schema([

                                    Select::make('reading_for')
                                        ->options([
                                            'Chiller' => 'Chiller',
                                            'AHU' => 'AHU',
                                            'FCU' => 'FCU',
                                        ])
                                        ->label('Select Equipment Type')
                                        ->nullable(),
                                    Select::make('refrigerant_type')
                                        ->options([
                                            'R410a' => 'R410a',
                                        ])->nullable(),

                                    Select::make('compressor_type')
                                        ->options([
                                            'R410a' => 'R410a',
                                        ])->nullable()
                                ])->columnSpan(2),

                            Fieldset::make('Log Readings:')
                                ->columns(3)
                                ->schema([

                                    Fieldset::make('Suction Pressure')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('suction_pressure1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('suction_pressure2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('suction_pressure3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('suction_pressure4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Discharge Pressure')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('discharge_pressure1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('discharge_pressure2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('discharge_pressure3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('discharge_pressure4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Oil Pressure')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('oil_pressure1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('oil_pressure2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('oil_pressure3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('oil_pressure4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Suction Temperature')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('suction_temp1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('suction_temp2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('suction_temp3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('suction_temp4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Discharge Temperature')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('discharge_temp1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('discharge_temp2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('discharge_temp3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('discharge_temp4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Liquid Temperature')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('liquid_temp1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('liquid_temp2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('liquid_temp3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('liquid_temp4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Oil Temperature')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('oil_temp1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('oil_temp2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('oil_temp3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('oil_temp4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                    Fieldset::make('Discharge Superheat')
                                        ->columns(4)
                                        ->schema([
                                            TextInput::make('discharge_superheat1')->nullable()
                                                ->prefix('1')
                                                ->label(' '),
                                            TextInput::make('discharge_superheat2')->nullable()
                                                ->prefix('2')
                                                ->label(' '),
                                            TextInput::make('discharge_superheat3')->nullable()
                                                ->prefix('3')
                                                ->label(' '),
                                            TextInput::make('discharge_superheat4')->nullable()
                                                ->prefix('4')
                                                ->label(' '),
                                        ]),

                                ])->columnSpan(2),

                        ]),
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    Step::make('Log Readings-2')
                        ->description(' ')
                        ->columns(2)
                        ->schema([
                            
                            Fieldset::make(' ')
                                ->columns(4)
                                ->schema([
                                    Fieldset::make('Water Cooled Chiller (Water In / Water Out)')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('wcc_cooler_temp')->nullable()
                                                ->suffix(' ')
                                                ->label('Cooler'),
                                            TextInput::make('wcc_condenser_temp')->nullable()
                                                ->suffix(' ')
                                                ->label('Condenser'),

                                        ])->columnSpan(2),

                                    Fieldset::make('Air Cooled Chiller (Water In / Water Out)')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('acc_cooler_temp')->nullable()
                                                ->suffix(' ')
                                                ->label('Temperature'),
                                            TextInput::make('acc_ambient_temp')->nullable()
                                                ->suffix(' ')
                                                ->label('Ambient Temperature'),

                                        ])->columnSpan(2),

                                    Fieldset::make('Pressure')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('pressure_cooler_water_in')->nullable()
                                                ->suffix('In')
                                                ->label('Cooler'),
                                            TextInput::make('pressure_condenser_water_in')->nullable()
                                                ->suffix('In')
                                                ->label('Condenser'),
                                            TextInput::make('pressure_cooler_water_out')->nullable()
                                                ->suffix('Out')
                                                ->label('Cooler'),
                                            TextInput::make('pressure_condenser_water_out')->nullable()
                                                ->suffix('Out')
                                                ->label('Condenser'),
                                        ]),

                                    Fieldset::make('Water Pressure Drop')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('water_pressure_drop_cooler')->nullable()
                                                ->label('Cooler'),
                                            TextInput::make('water_pressure_drop_condenser')->nullable()
                                                ->label('Condenser'),
                                        ]),

                                    Fieldset::make('Approach - Condenser')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('approach_condenser_cooler_temp')->nullable()
                                                ->label('Cooler'),
                                            TextInput::make('approach_condenser_condenser_temp')->nullable()
                                                ->label('Condenser'),
                                        ]),

                                    Fieldset::make('Approach - Evaporator')
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('approach_evaporator_cooler_temp')->nullable()
                                                ->label('Cooler'),
                                            TextInput::make('approach_evaporator_condenser_temp')->nullable()
                                                ->label('Condenser'),
                                        ]),

                                ]),


                            
                        ]),
////////////////////////////////////////////////////////////////////////////////////////////////
                    Step::make('Recommendations')
                        ->columns(4)
                        ->schema([
                            Select::make('replacements')
                                ->label('Part/s To Be Replace ')
                                ->relationship('replacements', 'model')
                                ->multiple()
                                ->nullable()
                                ->searchable()
                                ->columnSpan(4)
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('part_quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->nullable()
                                        ->columnSpan(1),
                                    TextInput::make('brand')
                                        ->nullable()
                                        ->columnSpan(1),
                                    TextInput::make('model')
                                        ->nullable()
                                        ->columnSpan(1),
                                    TextInput::make('part_no')
                                        ->nullable()
                                        ->columnSpan(1),
                                    TextArea::make('part_description')
                                        ->nullable()
                                        ->rows(2)
                                        ->columnSpan(4),
                                ])->createOptionModalHeading('Create Equipment for Replacement'),

                            MarkdownEditor::make('recommendation')
                                ->label('Recommendations / Existing Condition / For Customer Urgent Action')
                                ->nullable()
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ])
                                ->columnSpan(4),
                        ]),
///////////////////////////////////////////////////////////////////////////////////////////////////
Step::make('Customer Satisfaction')
                        ->columns(4)
                        ->schema([
                            MarkdownEditor::make('response_time')
                                ->nullable()
                                ->columnSpan(3)
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ]),
                            RatingStar::make('response_time_rate')
                                ->nullable()
                                ->label('Rating')
                                ->columnSpan(1),
                            MarkdownEditor::make('service_time')
                                ->nullable()
                                ->columnSpan(3)
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ]),
                            RatingStar::make('service_time_rate')
                                ->nullable()
                                ->label('Rating')
                                ->columnSpan(1),
                            MarkdownEditor::make('resolution_time')
                                ->nullable()
                                ->columnSpan(3)
                                ->disableToolbarButtons([
                                    'attachFiles',
                                    'blockquote',
                                    'bold',
                                    // 'bulletList',
                                    'codeBlock',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'table',
                                    'undo',
                                ]),
                            RatingStar::make('resolution_time_rate')
                                ->nullable()
                                ->label('Rating')
                                ->columnSpan(1),
                            MarkdownEditor::make('suggestions')
                                ->nullable()
                                ->columnSpan(3),

                                Select::make('user_id')
                                ->relationship('author', 'name')
                                ->searchable()
                                ->required()
                                ->preload()
                                ->columnSpan(1),
                        ]),

///////////////////////////////////////////////////////////////////////////////////////////////////
                ])
                ->skippable()
                ->columnSpanFull()
                // ->submitAction(new HtmlString('<button type="submit">Submit</button>'))

                ->submitAction(new HtmlString(Blade::render(<<<BLADE
            <x-filament::button
                type="submit"
                size="xl"
            >
                Submit
            </x-filament::button>
        BLADE)))
        ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->heading('Field Service Reports')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->striped()
            ->columns([
                Grid::make([
                    'sm' => 5,
                ])
                    ->schema([
                        
                            TextColumn::make('job_date_started')
                                ->default('No Data')
                                ->since()
                                ->sortable()
                                ->searchable()
                                ->label('Date')
                                ->alignment(Alignment::Center)
                                ->grow(false),
                            TextColumn::make('fsr_no')
                                ->default('No Data')
                                ->sortable()
                                ->searchable()
                                ->weight(FontWeight::Bold)
                                ->grow(false)
                                ->alignment(Alignment::Center)
                                ->label('FSR No.'),
                                // ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ' ' . $state),
                            TextColumn::make('project.name',)
                                ->default('No Data')
                                ->sortable()
                                ->searchable()
                                ->grow(false)
                                ->alignment(Alignment::Start)
                                ->label('Project'),
                                // ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),
                            TextColumn::make('attended_to')
                                ->default('No Data')
                                ->searchable()
                                ->badge()
                                ->grow(false)
                                ->label('Service Type')->columnSpan(2)
                        ,

                    
                        // Stack::make([
                        //         TextColumn::make('service_rendered')
                        //             ->searchable()
                        //             ->label('SERVICE RENDERED')
                        //             // ->size(TextEntry\TextEntrySize::Large)
                        //             // ->wrap()
                        //             ->lineClamp(4)
                        //             ->listWithLineBreaks()
                        //             ->grow(false)
                        //             ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),
                        //             // ->description(fn (Fsr $record): string => $record->service_rendered),

                        //             TextColumn::make('concerns')
                        //             ->searchable()
                        //             ->label('CONCERNS')
                        //             // ->wrap()
                        //             ->lineClamp(4)
                        //             ->listWithLineBreaks()
                        //             ->grow(false)
                        //             ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),

                        //             TextColumn::make('recommendation')
                        //             ->searchable()
                        //             ->label('RECOMMENDATION')
                        //             // ->wrap()
                        //             ->lineClamp(4)
                        //             ->listWithLineBreaks()
                        //             ->grow(false)
                        //             ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),
                            
                        // ])  ->space(2)->grow(true)->columnSpan(4),

                        ]),
                    Panel::make([
                    Stack::make([
                        TextColumn::make('service_rendered')
                                    ->default('No Data')
                                    ->searchable()
                                    ->label('SERVICE RENDERED')
                                    // ->size(TextEntry\TextEntrySize::Large)
                                    // ->wrap()
                                   
                                    ->listWithLineBreaks()
                                    ->grow(false)
                                    ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),
                                    // ->description(fn (Fsr $record): string => $record->service_rendered),

                                    TextColumn::make('concerns')
                                    ->default('No Data')
                                    ->searchable()
                                    ->label('CONCERNS')
                                    // ->wrap()
                                
                                    ->listWithLineBreaks()
                                    ->grow(false)
                                    ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),

                                    TextColumn::make('recommendation')
                                    ->default('No Data')
                                    ->searchable()
                                    ->label('RECOMMENDATION')
                                    // ->wrap()
                                    
                                    ->listWithLineBreaks()
                                    ->grow(false)
                                    ->formatStateUsing(fn (Column $column, $state): string => $column->getLabel() . ': ' . $state),
                            
                    ])
                    ])->collapsible()->grow(true)->columnSpan(4),
            

            ])
            ->defaultSort('fsr_no', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()

            ->filters([

                SelectFilter::make('project_id')
                ->label('Project/Client')
                ->relationship('project', 'name')
                ->multiple()
                ->preload()
                ->searchable(),

                // SelectFilter::make('attended_to')
                // ->options([
                //     'Preventive Maintenance' => 'Preventive Maintenance',
                //     'Trouble Call' => 'Trouble Call',
                //     'Check Up' => 'Check-up',
                //     'Evaluation' => 'Evaluation',
                //     'Start Up' => 'Start Up',
                //     'Testing' => 'Testing',
                //     'Commissioning' => 'Commissioning',
                //     'Monitoring' => 'Monitoring',
                //     'Site Inspection' => 'Site Inspection',
                //     'Operatorship' => 'Operatorship',
                //     'Parts/Installation' => 'Parts/Installation',
                //     'Repair/Modification' => 'Repair/Modification',
                //     'Hauling' => 'Hauling',
                //     'Delivery' => 'Delivery',
                //     'Others' => 'Others',
                // ])
                // ->label('FSR Type')
                // ->multiple()
                // ->searchable()

                ],layout: FiltersLayout::AboveContentCollapsible)
                ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->slideOver()->modalWidth(MaxWidth::SixExtraLarge),
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

           
            PersonnelsRelationManager::class,
            EquipmentsRelationManager::class,
            ReplacementsRelationManager::class,
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFsrs::route('/'),
            'create' => Pages\CreateFsr::route('/create'),
            'edit' => Pages\EditFsr::route('/{record}/edit'),
        ];
    }
}
