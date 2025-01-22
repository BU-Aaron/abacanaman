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

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = data_get(request()->query('filters'), 'startDate', null);
        $this->endDate = data_get(request()->query('filters'), 'endDate', null);
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->maxDate(fn(Get $get) => $get('endDate') ?: now())
                            ->reactive()
                            ->afterStateUpdated(fn($state) => $this->startDate = $state),
                        DatePicker::make('endDate')
                            ->minDate(fn(Get $get) => $get('startDate') ?: now())
                            ->maxDate(now())
                            ->reactive()
                            ->afterStateUpdated(fn($state) => $this->endDate = $state),
                    ])
                    ->columns(2),
            ])->reactive(true);
    }

    public function getActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(OrderExporter::class)
                ->modifyQueryUsing(fn(Builder $query) => $query->dateRange($this->startDate, Carbon::parse($this->endDate)->addDay()))
                ->columnMapping(false)
        ];
    }
}
