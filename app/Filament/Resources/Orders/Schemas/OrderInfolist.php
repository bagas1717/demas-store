<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pesanan')
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('Nomor Pesanan')
                            ->copyable()
                            ->weight('bold'),

                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i'),

                        TextEntry::make('status')
                            ->label('Status Pesanan')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending_payment' => 'Menunggu Pembayaran',
                                'processing' => 'Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default => ucfirst($state),
                            }),

                        TextEntry::make('payment_status')
                            ->label('Status Pembayaran')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'unpaid' => 'Belum Dibayar',
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'expired' => 'Kedaluwarsa',
                                'refunded' => 'Dikembalikan',
                                default => ucfirst($state),
                            }),

                        TextEntry::make('stock_released_at')
                            ->label('Stok Dikembalikan Pada')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('Belum dikembalikan'),

                        TextEntry::make('stock_released_at')
                            ->label('Stok Kembali')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Pelanggan')
                    ->schema([
                        TextEntry::make('customer_name')
                            ->label('Nama'),

                        TextEntry::make('customer_phone')
                            ->label('WhatsApp')
                            ->copyable(),

                        TextEntry::make('customer_email')
                            ->label('Email')
                            ->placeholder('-'),

                        TextEntry::make('customer_note')
                            ->label('Catatan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Ringkasan Pembayaran')
                    ->schema([
                        TextEntry::make('subtotal')
                            ->label('Subtotal')
                            ->money('IDR'),

                        TextEntry::make('service_fee')
                            ->label('Biaya Layanan')
                            ->money('IDR'),

                        TextEntry::make('total')
                            ->label('Total Pembayaran')
                            ->money('IDR')
                            ->weight('bold'),

                        TextEntry::make('expires_at')
                            ->label('Batas Pembayaran')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),

                        TextEntry::make('paid_at')
                            ->label('Dibayar Pada')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 3,
                    ]),
            ]);
    }
}
