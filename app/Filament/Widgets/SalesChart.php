<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Performa Penjualan';

    protected ?string $description = 'Tren transaksi berhasil selama 7 hari terakhir.';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 2,
    ];

    protected function getData(): array
    {
        $dates = collect(range(6, 0))
            ->map(fn (int $daysAgo) => now()->subDays($daysAgo)->startOfDay())
            ->push(now()->startOfDay());

        $paidOrders = Order::query()
            ->where('payment_status', 'paid')
            ->whereDate('created_at', '>=', $dates->first())
            ->get(['created_at', 'total']);

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan Dibayar',
                    'data' => $dates
                        ->map(fn (Carbon $date) => $paidOrders
                            ->filter(fn (Order $order) => $order->created_at->isSameDay($date))
                            ->count())
                        ->all(),
                    'borderColor' => '#304cb2',
                    'backgroundColor' => 'rgba(48, 76, 178, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Pendapatan',
                    'data' => $dates
                        ->map(fn (Carbon $date) => $paidOrders
                            ->filter(fn (Order $order) => $order->created_at->isSameDay($date))
                            ->sum('total'))
                        ->all(),
                    'borderColor' => '#ff7424',
                    'backgroundColor' => 'rgba(255, 116, 36, 0.10)',
                    'tension' => 0.35,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $dates
                ->map(fn (Carbon $date) => $date->translatedFormat('d M'))
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'position' => 'left',
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }
}
