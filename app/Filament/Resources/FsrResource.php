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
use App\Models\FsrEquipReplace;
use App\Models\Project;
use App\Models\Rating;
use Carbon\Carbon;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
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
use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Split as ComponentsSplit;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
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
use Filament\Infolists\Components\View;
use Filament\Infolists\Infolist;
use Filament\Notifications\Collection;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
// use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;


class FsrResource extends Resource
{
    protected static ?string $model = Fsr::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'FSR';

    protected static ?string $label = 'Field Service Report';

    use CreateRecord\Concerns\HasWizard;



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                GazeBanner::make()
                    ->lock()
                    ->canTakeControl()
                    ->hideOnCreate()
                    ->columnSpanFull(),
                Wizard::make([

                    //////////////////////////////////////////////////////////////////////////////////            
                    Wizard\Step::make('FSR Details')
                        ->description(' ')
                        ->columns([
                            'default' => 4,
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 4,
                            'xl' => 4,
                        ])
                        ->schema([

                            TextInput::make('fsr_no')
                                ->label('FSR No.')
                                ->unique(ignoreRecord: true)
                                ->disabledOn('edit')
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 1,
                                    'xl' => 1,
                                ]),

                            Select::make('project_id')
                                ->live()
                                ->label('Project/Client')
                                ->relationship('project', 'name')
                                ->searchable()
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 'full',
                                    'md' => 2,
                                    'lg' => 2,
                                    'xl' => 2,
                                ])
                                ->preload()
                                ->nullable()
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
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 1,
                                    'xl' => 1,
                                ])
                                ->preload()
                                ->createOptionForm([
                                    Section::make(' ')
                                        ->description(' ')
                                        ->schema([
                                            FileUpload::make('profile_photo_path')
                                                ->image()
                                                ->avatar()
                                                ->imageEditor()
                                                ->circleCropper()
                                                ->getUploadedFileNameForStorageUsing(
                                                    fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                        ->prepend('profile-photo-'),
                                                )
                                                ->label('Photo')
                                                ->directory('profiles')
                                                ->visibility('public')
                                                ->nullable(),

                                        ])->columnSpan(1),



                                    Section::make(' ')
                                        ->description(' ')
                                        ->schema([
                                            TextInput::make('name')
                                                ->required(),
                                            TextInput::make('designation')->nullable(),
                                            ToggleButtons::make('employee_status')->inline()
                                                ->options([
                                                    'Active' => 'Active',
                                                    'Inactive' => 'Inactive',
                                                    'Resigned' => 'Resigned',
                                                ])
                                                ->colors([
                                                    'Active' => 'success',
                                                    'Inactive' => 'info',
                                                    'Resigned' => 'warning',
                                                ])
                                                ->nullable(),


                                        ])->columnSpan(3),
                                ])->createOptionModalHeading('Create New Personnel'),

                            DatePicker::make('job_date_started')
                                ->label('Date Started')
                                ->columnSpan([
                                    'default' => 2,
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 2,
                                    'xl' => 1,
                                ])
                                ->date()
                                ->default('Carbon::today()'),
                            TimePicker::make('time_arrived')
                                ->label('Time Arrived')
                                ->columnSpan([
                                    'default' => 2,
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 2,
                                    'xl' => 1,
                                ])
                                ->time()
                                ->default(Carbon::now()),
                            DatePicker::make('job_date_finished')
                                ->label('Date Finished')
                                ->columnSpan([
                                    'default' => 2,
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 2,
                                    'xl' => 1,
                                ])
                                ->date()
                                ->default(Carbon::today()),
                            TimePicker::make('time_completed')
                                ->label('Time Completed')
                                ->columnSpan([
                                    'default' => 2,
                                    'sm' => 'full',
                                    'md' => 1,
                                    'lg' => 2,
                                    'xl' => 1,
                                ])
                                ->time()
                                ->default(Carbon::now()),



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
                                    'Retrofitting' => 'Retrofitting',
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
                    Wizard\Step::make('Equipment')
                        ->description('Status')
                        ->columns(4)
                        ->schema([
                            Select::make('equipments')
                                ->label(' ')
                                ->columnSpan(4)
                                ->multiple()
                                ->relationship('equipments', 'model')
                                ->searchable()
                                ->nullable()
                                ->getOptionLabelFromRecordUsing(fn(Equipment $record) => "{$record->brand} - {$record->model} | Serial No.:{$record->serial}")
                                ->searchable(['brand', 'model', 'serial'])
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
                    Wizard\Step::make('Log Readings-1')
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
                    Wizard\Step::make('Log Readings-2')
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
                    Wizard\Step::make('Recommendations')
                        ->columns(4)
                        ->schema([
                            Select::make('replacements')
                                ->label('Part/s To Be Replace ')
                                ->relationship('replacements', 'model')
                                ->multiple()
                                ->nullable()
                                ->searchable()
                                ->columnSpan(4)
                                ->getOptionLabelFromRecordUsing(fn(FsrEquipReplace $record) => "{$record->brand} - {$record->model} | Part No.:{$record->part_no}")
                                ->searchable(['brand', 'model', 'part_no'])
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
                    Wizard\Step::make('Customer Satisfaction')
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
                                ->disabled()
                                ->relationship('author', 'name')
                                ->default(Auth::user()->id)
                                // ->hidden()
                                // ->searchable()
                                ->required()
                                ->preload()
                                // ->readOnly()
                                ->columnSpan(1),
                        ]),

                    ///////////////////////////////////////////////////////////////////////////////////////////////////
                ])
                    ->skippable()
                    ->columnSpanFull()

                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                                <x-filament::button
                                    type="submit"
                                    size="xl"
                                >
                                    Submit
                                </x-filament::button>
                            BLADE))),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->heading('FSR List')
            ->description('Click the funnel to filter the list.')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            // ->searchable()
            ->striped()
            ->columns([
                LayoutView::make('filament.table.row-content')
                    ->components([
                        TextColumn::make('attended_to')
                            ->badge()
                            ->icon('heroicon-m-wrench'),
                    ]),
                LayoutView::make('filament.table.collapsible-row-content')
                    ->collapsible(),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('fsr_no', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()

            ->filters(
                [
                    // Filter::make('fsr_no')
                    //     ->form([
                    //         TextInput::make('fsr_no')->label('FSR No.')
                    //             ->helperText('Search FSR No. only'),
                    //     ])
                    //     ->query(function (Builder $query, array $data): Builder {
                    //         if (!empty($data['fsr_no'])) {
                    //             $fsrNo = $data['fsr_no'];
                    //             return $query->where('fsr_no', 'like', '%' . $fsrNo . '%');
                    //         }
                    //         return $query;
                    //     }),
                    Filter::make('fsr_no')
                        ->form([
                            TextInput::make('fsr_no')->label('FSR No.')
                                ->helperText('Search FSR No. only'),
                            Select::make('fsr_no_duplicate')
                                ->label('FSR No. Duplicate Filter')
                                ->options([
                                    'all' => 'All FSRs',
                                    'duplicate' => 'Duplicate FSRs',
                                    'unique' => 'Unique FSRs',
                                ])
                                ->default('all'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            // Filter by FSR No.
                            if (!empty($data['fsr_no'])) {
                                $fsrNo = $data['fsr_no'];
                                $query->where('fsr_no', 'like', '%' . $fsrNo . '%');
                            }

                            // Filter for duplicates or unique based on the selected option
                            if (!empty($data['fsr_no_duplicate'])) {
                                if ($data['fsr_no_duplicate'] === 'duplicate') {
                                    $query->whereIn('fsr_no', function ($subQuery) {
                                        $subQuery->select('fsr_no')
                                            ->from('fsrs')
                                            ->groupBy('fsr_no')
                                            ->havingRaw('COUNT(fsr_no) > 1');
                                    });
                                } elseif ($data['fsr_no_duplicate'] === 'unique') {
                                    $query->whereNotIn('fsr_no', function ($subQuery) {
                                        $subQuery->select('fsr_no')
                                            ->from('fsrs')
                                            ->groupBy('fsr_no')
                                            ->havingRaw('COUNT(fsr_no) > 1');
                                    });
                                }
                            }

                            return $query;
                        }),



                    Filter::make('attended_to')
                
                        ->form([
                            TextInput::make('attended_to')->label('FSR Type')
                                ->helperText('ex.: Preventive Maintenance, Trouble Call or Hauling'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            if (!empty($data['attended_to'])) {
                                $fsrNo = $data['attended_to'];
                                return $query->where('attended_to', 'like', '%' . $fsrNo . '%');
                            }
                            return $query;
                        }),
                    SelectFilter::make('project_id')

                        ->label('Project/Client')
                        ->relationship('project', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),

                ],
                // layout: FiltersLayout::AboveContentCollapsible)
                layout: FiltersLayout::AboveContent
            )
            ->filtersFormColumns(4)
            ->actions([

                EditAction::make(),
                ViewAction::make(),
                ViewAction::make('timeline')
                    ->label('Timeline')
                    ->icon('heroicon-m-magnifying-glass-circle')
                    ->url(fn(Fsr $record): string => route('filament.admin.resources.projects.view', $record->project_id)),


            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()
                        ->askForFilename()
                        ->withFilename(fn ($filename) => ''. $filename)
                        ->withColumns([
                            Column::make('fsr_no'),
                            Column::make('time_arrived'),
                            Column::make('time_completed'),
                            Column::make('job_date_started')
                            ->heading('Date Started'),
                            Column::make('job_date_finished')
                            ->heading('Date Finished'),
                            Column::make('project.name')
                            ->heading('Project Name'),
                            Column::make('attended_to'),
                            Column::make('encoder'),
                        ])
                    ])
                    ->label('Export Selected')
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                View::make('infolists.components.fsr-view')->columnSpanFull(),
                CommentsEntry::make('fsr_comments')->columnSpanFull(),
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
            'view' => Pages\ViewFsr::route('/{record}'),
            'edit' => Pages\EditFsr::route('/{record}/edit'),
        ];
    }
}
