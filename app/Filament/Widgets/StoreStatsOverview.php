<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $paidRevenue = (int) Order::query()
            ->where('payment_status', 'paid')
            ->sum('total');

        $todayOrders = Order::query()
            ->whereDate('created_at', today())
            ->count();

        $pendingPayments = Order::query()
            ->where('payment_status', 'pending')
            ->count();

        $lowStock = ProductVariant::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        return [
            Stat::make(
                'Pendapatan',
                'Rp' . number_format($paidRevenue, 0, ',', '.')
            )
                ->description('Total transaksi berhasil')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->color('success'),

            Stat::make('Pesanan Hari Ini', $todayOrders)
                ->description('Pesanan masuk hari ini')
                ->descriptionIcon(Heroicon::OutlinedShoppingBag)
                ->color('info'),

            Stat::make('Menunggu Pembayaran', $pendingPayments)
                ->description('Pesanan belum dibayar')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color('warning'),

            Stat::make('Stok Menipis', $lowStock)
                ->description(
                    Product::query()->count() . ' produk aktif dipantau'
                )
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
                ->color($lowStock > 0 ? 'danger' : 'success'),
        ];
    }
}
