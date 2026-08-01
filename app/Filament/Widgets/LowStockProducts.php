<?php

namespace App\Filament\Widgets;

use App\Models\ProductVariant;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LowStockProducts extends TableWidget
{
    protected static ?string $heading = 'Produk yang Perlu Restok';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ProductVariant::query()
                    ->with('product')
                    ->whereColumn('stock', '<=', 'minimum_stock')
                    ->orderBy('stock')
            )
            ->emptyStateHeading('Stok aman')
            ->emptyStateDescription('Belum ada produk yang mencapai batas stok minimum.')
            ->emptyStateIcon(Heroicon::OutlinedCheckCircle)
            ->columns([
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Varian')
                    ->searchable(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->copyable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn (int $state): string => $state <= 0 ? 'danger' : 'warning')
                    ->sortable(),

                TextColumn::make('minimum_stock')
                    ->label('Minimum')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label('Atur Stok')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->url(
                        fn (ProductVariant $record): string =>
                            url('/admin/product-variants/' . $record->getKey() . '/edit')
                    ),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
