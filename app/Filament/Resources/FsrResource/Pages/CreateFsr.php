<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use App\Models\Equipment;
use App\Models\FsrEquipReplace;
use Carbon\Carbon;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use IbrahimBougaoua\FilamentRatingStar\Forms\Components\RatingStar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateFsr extends CreateRecord
{

    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = FsrResource::class;

    protected static bool $canCreateAnother = false;
    // protected static bool $canCreate = false;
    protected function getRedirectUrl(): string
{
    return $this->previousUrl ?? $this->getResource()::getUrl('index');
}

    protected function getSteps(): array
    {
        return [
            Step::make('FSR Details')
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
                                TextInput::make('designation')->nullable()->columnSpan(2),
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
                                ])->columnSpan(2),
                        ])->columns(3)->createOptionModalHeading('Create New Personnel'),

                    DatePicker::make('job_date_started')
                        ->label('Date Started')
                        ->date()
                        ->nullable()
                        ->columnSpan([
                            'default' => 2,
                            'sm' => 'full',
                            'md' => 1,
                            'lg' => 2,
                            'xl' => 1,
                        ])
                        ->default(Carbon::today()),
                    TimePicker::make('time_arrived')
                        ->label('Time Arrived')
                        ->time()
                        ->nullable()
                        ->columnSpan([
                            'default' => 2,
                            'sm' => 'full',
                            'md' => 1,
                            'lg' => 2,
                            'xl' => 1,
                        ])
                        ->default(Carbon::now()),
                    DatePicker::make('job_date_finished')
                        ->label('Date Finished')
                        ->date()
                        ->nullable()
                        ->columnSpan([
                            'default' => 2,
                            'sm' => 'full',
                            'md' => 1,
                            'lg' => 2,
                            'xl' => 1,
                        ])
                        ->default(Carbon::today()),
                    TimePicker::make('time_completed')
                        ->label('Time Completed')
                        ->time()
                        ->nullable()
                        ->columnSpan([
                            'default' => 2,
                            'sm' => 'full',
                            'md' => 1,
                            'lg' => 2,
                            'xl' => 1,
                        ])
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
                        ->getOptionLabelFromRecordUsing(fn (Equipment $record) => "{$record->brand} - {$record->model} | Serial No.:{$record->serial}")
                                ->searchable(['brand', 'model', 'serial'])
                        // ->preload()
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
                        ])
                        ->createOptionModalHeading('Create New Equipment'),

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
                        ])
                        ->columnSpan(2),

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
                        ])
                        ->columnSpan(2),

                    Fieldset::make(' ')
                        ->columns(3)
                        ->schema([
                            TextInput::make('voltage_imbalance')->nullable(),
                            TextInput::make('current_imbalance')->nullable(),
                            TextInput::make('control_voltage')->nullable(),
                        ])
                        ->columnSpan(4),

                    MarkdownEditor::make('service_rendered')
                        ->nullable()
                        ->columnSpan(4)
                        ->disableToolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
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
                                    'WCP' => 'WCP',
                                    'AHU' => 'AHU',
                                    'FCU' => 'FCU',
                                    'ACP' => 'ACP',
                                    'PECISION A/C' => 'PRECISION A/C',
                                ])
                                ->label('Select Equipment Type')
                                ->nullable(),
                            TextInput::make('refrigerant_type')
                                // ->options([
                                //     'R410a' => 'R410a',
                                // ])
                                ->nullable(),

                            Select::make('compressor_type')
                                ->options([
                                    'Centrifugal' => 'Centrifugal',
                                    'Rotary Screw' => 'Rotary Screw',
                                    'HSC' => 'HSC',
                                    'VSC' => 'VSC',
                                    'Oilless Magnetic' => 'Oilless Magnetic',
                                    'Scroll' => 'Scroll',
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
                        ->getOptionLabelFromRecordUsing(fn (FsrEquipReplace $record) => "{$record->brand} - {$record->model} | Part No.:{$record->part_no}")
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
                        ->default(Auth::user()->id)
                        // ->disabled()
                        ->columnSpan(1),
                ])
                ->columnSpanFull(),


            ///////////////////////////////////////////////////////////////////////////////////////////////////
        
                    ];
    }
}
