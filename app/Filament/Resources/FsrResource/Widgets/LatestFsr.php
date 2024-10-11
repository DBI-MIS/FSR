<?php

namespace App\Filament\Resources\FsrResource\Widgets;

use App\Filament\Resources\FsrResource;
use App\Models\Fsr;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Database\Query\Builder;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Enums\ActionsPosition;

class LatestFsr extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(FsrResource::getEloquentQuery())
            ->defaultPaginationPageOption(12)
            ->defaultSort('created_at', 'desc')
            ->columns([
                View::make('filament.table.row-content')
                    ->components([
                        TextColumn::make('attended_to')
                            ->badge()
                            ->icon(
                                fn(string $state): string =>
                                match ($state) {
                                    'Preventive Maintenance' => 'heroicon-m-wrench-screwdriver',
                                    'Trouble Call' => 'heroicon-m-exclamation-triangle',
                                    'Check Up' => 'heroicon-m-check-circle',
                                    'Evaluation' => 'heroicon-m-clipboard-document-check',
                                    'Start Up' => 'heroicon-m-forward',
                                    'Testing' => 'heroicon-m-swatch',
                                    'Commissioning' => 'heroicon-m-arrow-trending-up',
                                    'Monitoring' => 'heroicon-m-computer-desktop',
                                    'Site Inspection' => 'heroicon-m-magnifying-glass-plus',
                                    'Operatorship' => 'heroicon-m-user',
                                    'Parts/Installation' => 'heroicon-m-arrow-up-on-square-stack',
                                    'Repair/Modification' => 'heroicon-m-wrench-screwdriver',
                                    'Hauling' => 'heroicon-m-square-2-stack',
                                    'Delivery' => 'heroicon-m-truck',
                                    'Retrofitting' => 'heroicon-m-squares-plus',
                                    'Others' => 'heroicon-m-receipt-refund',
                                    default => 'heroicon-m-wrench',
                                }
                            )
                            ->color(fn(string $state): string => match ($state) {
                                'Preventive Maintenance' => 'primary',
                                'Trouble Call' => 'danger',
                                'Check Up' => 'warning',
                                'Evaluation' => 'warning',
                                'Start Up' => 'success',
                                'Testing' => 'warning',
                                'Commissioning' => 'primary',
                                'Monitoring' => 'success',
                                'Site Inspection' => 'success',
                                'Operatorship' => 'primary',
                                'Parts/Installation' => 'info',
                                'Repair/Modification' => 'danger',
                                'Hauling' => 'success',
                                'Delivery' => 'success',
                                'Retrofitting' => 'warning',
                                'Others' => 'info',
                                default => 'gray',
                            })
                    ]),
                View::make('filament.table.collapsible-row-content')
                    ->collapsible(),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()
                    ->url(fn(Fsr $record): string => route('filament.admin.resources.fsrs.edit', $record))
                    ->hidden(auth()->user()->role !== 'ADMIN'),
                ViewAction::make('view')
                    ->label('View')
                    ->url(fn(Fsr $record): string => route('filament.admin.resources.fsrs.view', $record)),
                ViewAction::make('timeline')
                    ->label('Timeline')
                    ->icon('heroicon-m-magnifying-glass-circle')
                    ->url(fn(Fsr $record): string => route('filament.admin.resources.projects.view', $record->project_id))
            ])

        ;
    }
}
