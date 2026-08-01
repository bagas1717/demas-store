<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestOrders extends TableWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->latest()
                    ->limit(6)
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Pesanan')
                    ->copyable()
                    ->weight('bold')
                    ->description(
                        fn (Order $record): string =>
                            $record->customer_name
                    ),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR'),

                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            match ($state) {
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'expired' => 'Kedaluwarsa',
                                'refunded' => 'Refund',
                                default => 'Menunggu',
                            }
                    )
                    ->color(
                        fn (string $state): string =>
                            match ($state) {
                                'paid' => 'success',
                                'failed',
                                'expired' => 'danger',
                                'refunded' => 'warning',
                                default => 'gray',
                            }
                    ),
            ])
            ->recordActions([
                Action::make('detail')
                    ->label('Detail')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(
                        fn (Order $record): string =>
                            OrderResource::getUrl(
                                'view',
                                [
                                    'record' =>
                                        $record->getRouteKey(),
                                ]
                            )
                    ),
            ])
            ->paginated(false)
            ->defaultSort('created_at', 'desc');
    }
}