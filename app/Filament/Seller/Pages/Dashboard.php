<?php

namespace App\Filament\Seller\Pages;

use App\Filament\Seller\Exports\Shop\OrderExporter;
use Carbon\Carbon;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Database\Eloquent\Builder;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function getHeaderActions(): array
    {
        return [
            ExportAction::make()->exporter(OrderExporter::class),
        ];
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->maxDate(fn(Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->minDate(fn(Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(2),
            ]);
    }

    public function getActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(OrderExporter::class)
                ->modifyQueryUsing(fn(Builder $query) => $query->dateRange($this->startDate, Carbon::parse($this->endDate)->addDay()))
        ];
    }
}
