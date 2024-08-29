<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 20;

    public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            GazeBanner::make()
            ->lock()
            ->canTakeControl()
            ->hideOnCreate()
            ->columnSpanFull(),

            FileUpload::make('picture')
            ->imageEditor()
            ->imageEditorMode(2)
            ->circleCropper()
            ->getUploadedFileNameForStorageUsing(
                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                    ->prepend('profile-photo-'),
            )
            ->label('Photo')
            ->directory('users')
            ->visibility('public')
            ->nullable()
            ->panelLayout('circle')
            ->panelAspectRatio('1:1')
            ->imageCropAspectRatio('1:1')
            ->columnSpan(1),
           
            Section::make(' ')
            ->description(' ')
            ->schema([
            TextInput::make('name')
                ->required()
                ->columnSpan(2),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->columnSpan(2),
            TextInput::make('password')
                ->password()
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))
                ->columnSpan(2),
                Select::make('role')
                ->options(User::ROLES)
                ->required()
                ->columnSpan(2),
           
           
            ])->columnSpan(3),

        ])->columns(4);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('picture')
                    ->circular()
                    ->defaultImageUrl(url('user_profile.svg'))
                    ->size(40)
                    ->label(' '),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
