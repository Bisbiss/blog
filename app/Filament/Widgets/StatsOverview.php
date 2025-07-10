<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Category;
use App\Models\Gallery;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Post', Post::count())
                ->description('Total postingan yang dibuat')
                ->color('primary'),

            Stat::make('Jumlah Gallery', Gallery::count())
                ->description('Jumlah gambar di galeri')
                ->color('success'),

            Stat::make('Jumlah Kategori', Category::count())
                ->description('Kategori yang tersedia')
                ->color('warning'),
        ];
    }
}
