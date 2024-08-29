<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DbePersonnelResource\Pages;
use App\Filament\Resources\DbePersonnelResource\RelationManagers;
use App\Models\DbePersonnel;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DbePersonnelResource extends Resource
{
    protected static ?string $model = DbePersonnel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Personnels';

    protected static ?string $label = 'DBE Personnel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(' ')
                    ->description(' ')
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->circleCropper()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                    ->prepend('profile-photo-'),
                            )
                            ->label('Photo')
                            ->directory('profiles')
                            ->visibility('public')
                            ->panelLayout('circle')
                            ->panelAspectRatio('1:1')
                            ->imageCropAspectRatio('1:1')
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



            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('DBE Personnels')
            ->defaultPaginationPageOption(25)
            ->deferLoading()
            ->defaultSort('employee_status', 'asc')
            ->columns([
                GazeBanner::make()
                ->lock()
                ->canTakeControl()
                ->hideOnCreate()
                ->columnSpanFull(),
                TextColumn::make('id')
                    ->searchable(),
                ImageColumn::make('profile_photo_path')
                    ->circular()
                    ->defaultImageUrl(url('user_profile.svg'))
                    // ->ring(5)
                    ->size(40)
                    ->label(' ')
                // ->checkFileExistence(false)
                // ->visibility('public')
                ,
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('designation')
                    ->searchable()
                    ->default('No Data'),
                TextColumn::make('employee_status')
                ->badge()
                    ->label('Status')
                    ->searchable()
                    ->default('No Data')
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'info',
                        'Resigned' => 'warning',
                        }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
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
            'index' => Pages\ListDbePersonnels::route('/'),
            'create' => Pages\CreateDbePersonnel::route('/create'),
            'edit' => Pages\EditDbePersonnel::route('/{record}/edit'),
        ];
    }
}
