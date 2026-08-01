<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pesanan')
                    ->schema([
                        TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('customer_phone')
                            ->label('Nomor WhatsApp')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('customer_email')
                            ->label('Email')
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('customer_note')
                            ->label('Catatan Pelanggan')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Status')
                    ->description(
                        'Ubah status ini sesuai proses pesanan pelanggan.'
                    )
                    ->schema([
                        Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending_payment' => 'Menunggu Pembayaran',
                                'processing' => 'Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->required()
                            ->native(false),

                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Belum Dibayar',
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'expired' => 'Kedaluwarsa',
                                'refunded' => 'Dikembalikan',
                            ])
                            ->required()
                            ->native(false),

                        DateTimePicker::make('paid_at')
                            ->label('Waktu Pembayaran')
                            ->seconds(false),

                        DateTimePicker::make('expires_at')
                            ->label('Batas Pembayaran')
                            ->seconds(false),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Nilai Pesanan')
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('service_fee')
                            ->label('Biaya Layanan')
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('total')
                            ->label('Total')
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 3,
                    ]),
            ]);
    }
}
