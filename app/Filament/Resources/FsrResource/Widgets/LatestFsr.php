<?php

namespace App\Filament\Resources\FsrResource\Widgets;

use App\Filament\Resources\FsrResource;
use App\Models\Fsr;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Query\Builder;

class LatestFsr extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(FsrResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
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
                                // ->description(fn (Fsr $record): string => 'Date', position: 'above')
                                ->grow(false),
                            TextColumn::make('fsr_no')
                                ->default('No Data')
                                ->sortable()
                                ->searchable()
                                ->weight(FontWeight::Bold)
                                ->grow(false)
                                ->alignment(Alignment::Center)
                                // ->description(fn (Fsr $record): string => 'FSR No.:', position: 'above')
                                ->label('FSR No.'),
                                
                            TextColumn::make('project.name',)
                                ->default('No Data')
                                ->sortable()
                                ->searchable()
                                ->grow(false)
                                ->alignment(Alignment::Start)
                                ->description(fn (Fsr $record): string => 'Project:', position: 'above')
                                ->label('Project'),
                            TextColumn::make('attended_to')
                                ->default('No Data')
                                ->searchable()
                                ->badge()
                                ->grow(false)
                                ->label('Service Type')->columnSpan(1),
                            TextColumn::make('created_at')
                                ->default('No Data')
                                ->sortable()
                                ->date()
                                ->grow(false)
                                ->description(fn (Fsr $record): string => 'Date Encoded', position: 'above')
                                ->label('Date Encoded')->columnSpan(1)
                                
                        ,

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
            ;
    }
}
