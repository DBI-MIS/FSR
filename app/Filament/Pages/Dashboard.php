<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard

{
    use HasFiltersForm;
    use HasFiltersAction;
    

    // protected static ?string $navigationIcon = 'icon-home';
    protected static ?string $title = null;

    // public function mount()
    // {
    //     $user = Auth::user();
        
    //     static::$title = 'Hi there ' . ucwords(strtolower($user->name)) . '!';
    // }

    

    public function getSubheading(): ?string
    {

        $user = Auth::user();
        // $hour = Carbon::now()->hour; // Get the current hour
    
      return 'Good day '. ucwords(strtolower($user->name)) . '. Keep up the great work!';
    
       
    }

    public function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 1,
            'lg' => 2,
            // 'xl' => 5,
        ];
    }
 
    // public function filtersForm(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Section::make()
    //                 ->schema([
    //                     DatePicker::make('startDate'),
    //                     DatePicker::make('endDate'),
    //                 ])
    //                 ->columns(3),
    //         ]);
    // }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         FilterAction::make()
    //             ->form([
    //                 DatePicker::make('startDate'),
    //                 DatePicker::make('endDate'),
    //             ]),
    //     ];
    // }
}
