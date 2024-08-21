<?php

namespace App\Filament\Resources\FsrResource\Widgets;

use App\Filament\Resources\FsrResource;
use App\Models\Fsr;
use App\Models\Project;
use Filament\Actions\Action;
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
use Filament\Tables\Columns\Layout\View;

class LatestFsr extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(FsrResource::getEloquentQuery())
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc')
            ->columns([
                View::make('filament.table.row-content')
                    ->components([
                        TextColumn::make('attended_to')
                            ->badge()
                            ->icon('heroicon-m-wrench'),
                    ]),
                View::make('filament.table.collapsible-row-content')
                    ->collapsible(),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])->defaultSort('created_at', 'desc')
                ->actions([
                Tables\Actions\ViewAction::make('view')
                ->label('View Record')
                ->url(fn (Fsr $record): string => route('filament.admin.resources.fsrs.view', $record)),
                Tables\Actions\ViewAction::make('timeline')
                ->label('Project History')
                ->icon('heroicon-m-magnifying-glass-circle')
                ->url(fn (Fsr $record): string => route('filament.admin.resources.projects.view', $record->project_id))
                ])

            ;
    }
}
