<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        return 'Dashboard Demas Store';
    }

    public function getSubheading(): ?string
    {
        return 'Ringkasan penjualan, pesanan, dan kondisi stok toko.';
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }
}
