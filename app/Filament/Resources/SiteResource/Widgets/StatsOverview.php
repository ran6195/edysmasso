<?php

namespace App\Filament\Resources\SiteResource\Widgets;

use App\Models\Site;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totale siti', Site::all()->count())
                ->color('info')
                ->description('Siti sul server 713'),
            Stat::make('Siti J4', Site::where('J4', 1)->count())
                ->description('Siti con intallato Joomla v.4')
                ->color('success'),
            Stat::make('Siti J4 senza token', Site::whereNull('token')->where('J4', 1)->count())
                ->color('warning')
                ->description('Siti senza il token di Joomla'),

        ];
    }
}
