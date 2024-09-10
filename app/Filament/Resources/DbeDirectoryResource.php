<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DbeDirectoryResource\Pages;
use App\Filament\Resources\DbeDirectoryResource\RelationManagers;
use App\Models\DbeDirectory;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Infolists\Components\Component;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DbeDirectoryResource extends Resource
{
    protected static ?string $model = DbeDirectory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'DBE Directory';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Section::make()->schema([
                    Select::make('project_id')
                    ->live()
                    ->label('Project/Client')
                    ->relationship('directoryproject', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                    TextInput::make('status')
                    ->visibleOn('edit')
                    ->label('Status')
                    ->disabled(),                 

                ])->columnSpan(1),
                Section::make('CONTACT DETAILS')->schema([
                    Repeater::make('contact_id')
                        ->relationship('contactsdbe') 
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('contact_no')
                                    ->label('Contact No.')
                                    ->tel(),
                                TextInput::make('contact_person')
                                    ->label('Contact Name'),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('email_address')
                                    ->email()
                                    ->label('Email Address'),
                                TextInput::make('designation')
                                    ->label('Designation'),
                            ]),
                        ])
                        ->minItems(1) // Ensure at least one contact
                        ->addActionLabel('+ Add Another Contact'),
                ])->columnSpan(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            LayoutView::make('filament.table.dbe-directory')
               

        ])
        ->contentGrid([
            // 'default' => 3,
            'lg' => 1,
        ])

            // ->columns([
            //     TextColumn::make('project.name')  
            //     ->label('Project/Client')  
            //     ->sortable()
            //     ->searchable(),
            //     TextColumn::make('contact_no')
            //     ->label('Contact No.')
            //         ->sortable(),
            //     TextColumn::make('contact_person')
            //     ->label('Contact Person')
            //         ->searchable()
            //         ->sortable(),
            //     TextColumn::make('designation')
            //     ->label('Designation')
            //         ->searchable()
            //         ->sortable(),
            //     TextColumn::make('email_address')
            //     ->label('Email')
            //         ->sortable(),
            //     TextColumn::make('created_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            //     TextColumn::make('updated_at')
            //         ->dateTime()
            //         ->sortable()
            //         ->toggleable(isToggledHiddenByDefault: true),
            // ])
            ->filters([
                //
            ])
            ->actions([
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            View::make('infolists.components.view-dbe-directory')->columnSpanFull(),

        ]);
        
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['directoryproject.relatedfsrs']); 
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
            'index' => Pages\ListDbeDirectories::route('/'),
            'create' => Pages\CreateDbeDirectory::route('/create'),
            'edit' => Pages\EditDbeDirectory::route('/{record}/edit'),
            'view' => Pages\ViewDbeDirectory::route('/{record}'),
        ];
    }
}
