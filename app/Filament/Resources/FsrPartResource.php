<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FsrEquipReplaceResource\RelationManagers\FsrsRelationManager;
use App\Filament\Resources\FsrPartResource\Pages;
use App\Filament\Resources\FsrPartResource\RelationManagers;
use App\Filament\Resources\FsrPartResource\RelationManagers\FsrRelationManager;
use App\Filament\Resources\FsrPartResource\RelationManagers\ProjectRelationManager;
use App\Models\FsrPart;

use Filament\Forms;
use Filament\Infolists\Components\View;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\View as ComponentsView;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FsrPartResource extends Resource
{
    protected static ?string $model = FsrPart::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'FSR';

    protected static ?string $label = 'FSR Form';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->schema([
                    Select::make('project_id')
                    ->live()
                    ->label('Project/Client')
                    ->relationship('project', 'name')
                    ->searchable()
                    // ->columnSpan(2)
                    ->preload(),
    
                    Select::make('fsr_id')
                    ->live()
                    ->label('FSR No.')
                    ->relationship('fsr', 'fsr_no')
                    ->searchable()
                    // ->columnSpan(2)
                    ->preload(),
    
                    DatePicker::make('fsr_date')
                    ->label('Date')
                    ->nullable(),

                    Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'for_review' => 'For Review',
                    ])



                   
                        
                ])->columnSpan(1),

              Section::make()->schema([
                    Textarea::make('history')
                    ->rows(3),
                    MarkdownEditor::make('findings')
                    ->toolbarButtons([
                        'bulletList',
                    ]),
                    MarkdownEditor::make('action_done')
                    ->toolbarButtons([
                        'bulletList',
                    ]),
                    MarkdownEditor::make('recommendation')
                    ->toolbarButtons([
                        'bulletList',
                    ]),
              ])->columnSpan(2)

               
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                ->label('Project/Client')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fsr.fsr_no')
                ->label('FSR No.')
                ->sortable()
                ->searchable(),
                TextColumn::make('status')
                ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'for_review' => 'gray',
                        'completed' => 'success',
                 }),
              
            ])->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(25)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()   ,
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                View::make('filament.part.fsr-part-view')->columnSpanFull()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            // FsrRelationManager::class,
            // ProjectRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFsrParts::route('/'),
            'create' => Pages\CreateFsrPart::route('/create'),
            'edit' => Pages\EditFsrPart::route('/{record}/edit'),
            'view' => Pages\ViewFsrPart::route('/{record}'),
        ];
    }
}
