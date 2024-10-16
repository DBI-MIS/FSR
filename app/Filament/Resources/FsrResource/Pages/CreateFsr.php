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
                ->schema(FsrResource::getFsrDetails()),

            Step::make('Equipment')
                ->description('Status')
                ->columns(4)
                ->schema(FsrResource::getEquipmentStatus()),

            Step::make('Log Readings-1')
                ->description(' ')
                ->schema(FsrResource::getLogReadings1()),
            
                Step::make('Log Readings-2')
                ->description(' ')
                ->columns(2)
                ->schema(FsrResource::getLogReadings2()),
           
            Step::make('Recommendations')
                ->columns(4)
                ->schema(FsrResource::getRecommendations()),

            Step::make('Customer Satisfaction')
                ->columns(4)
                ->schema(FsrResource::getCustomerSatisfaction())
                ->columnSpanFull(),


        
                    ];
    }
}
