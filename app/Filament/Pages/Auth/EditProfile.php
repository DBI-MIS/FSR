<?php
 
namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\Enums\IconPosition;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                ->persistTabInQueryString()
                ->persistTab()
                    ->id('profile-tabs')
                ->tabs([
                    Tabs\Tab::make('Details')
                    ->icon('heroicon-m-user-circle')
                    ->iconPosition(IconPosition::Before)
                        ->schema([ 
                            $this->getNameFormComponent(),
                            $this->getEmailFormComponent(),
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                        ]),

                        Tabs\Tab::make('Photo')
                        ->icon('heroicon-m-photo')
                        ->iconPosition(IconPosition::Before)
                        ->schema([ 
                            FileUpload::make('picture')
                            // ->avatar()
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->circleCropper()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend('profile-photo-'),
                            )
                            ->label(' ')
                            ->directory('users')
                            ->visibility('public')
                            ->nullable()
                            ->panelLayout('circle')
                            ->panelAspectRatio('1:1')
                            ->imageCropAspectRatio('1:1'),
                        ]),
                    ])->contained(false),

                    
                
        
          
          
          
           
               
            ]);
    }
}