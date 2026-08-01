<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductVariantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Paket')
                    ->description(
                        'Pilih produk lalu isi nama dan identitas paket yang akan dijual.'
                    )
                    ->schema([
                        Select::make('product_id')
                            ->label('Produk')
                            ->relationship(
                                name: 'product',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: Sharing 1 Profil — 1 Bulan')
                            ->required()
                            ->maxLength(150)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (
                                ?string $state,
                                callable $set,
                                callable $get
                            ): void {
                                if (filled($get('sku'))) {
                                    return;
                                }

                                $set(
                                    'sku',
                                    Str::upper(
                                        Str::slug($state ?? '', '-')
                                    )
                                );
                            }),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->placeholder('NETFLIX-SHARING-1M')
                            ->helperText(
                                'Kode unik paket. Tidak boleh sama dengan paket lain.'
                            )
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),

                        Select::make('account_type')
                            ->label('Jenis Akun')
                            ->options([
                                'sharing' => 'Sharing',
                                'private' => 'Private',
                                'family' => 'Family',
                                'invite' => 'Invite Email',
                                'head_email' => 'Head Email',
                                'redeem' => 'Redeem / Kode',
                                'other' => 'Lainnya',
                            ])
                            ->searchable()
                            ->native(false)
                            ->placeholder('Pilih jenis akun'),

                        TextInput::make('user_limit')
                            ->label('Jumlah Pengguna')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Contoh: 1'),

                        TextInput::make('profile_limit')
                            ->label('Jumlah Profil')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Contoh: 1'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Durasi Paket')
                    ->schema([
                        TextInput::make('duration_value')
                            ->label('Jumlah Durasi')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Contoh: 1'),

                        Select::make('duration_unit')
                            ->label('Satuan Durasi')
                            ->options([
                                'day' => 'Hari',
                                'week' => 'Minggu',
                                'month' => 'Bulan',
                                'year' => 'Tahun',
                                'lifetime' => 'Lifetime',
                            ])
                            ->native(false)
                            ->placeholder('Pilih satuan durasi'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Harga dan Stok')
                    ->description(
                        'Harga ditulis dalam angka rupiah tanpa titik atau koma.'
                    )
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga Jual')
                            ->prefix('Rp')
                            ->placeholder('38000')
                            ->helperText(
                                'Contoh: Rp38.000 ditulis sebagai 38000.'
                            )
                            ->required()
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('compare_price')
                            ->label('Harga Sebelum Diskon')
                            ->prefix('Rp')
                            ->placeholder('45000')
                            ->helperText(
                                'Kosongkan jika paket tidak memiliki harga coret.'
                            )
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('stock')
                            ->label('Jumlah Stok')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        TextInput::make('minimum_stock')
                            ->label('Batas Stok Minimum')
                            ->helperText(
                                'Admin dapat memakai nilai ini sebagai peringatan stok menipis.'
                            )
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(3),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Garansi dan Catatan')
                    ->schema([
                        Textarea::make('warranty_text')
                            ->label('Informasi Garansi')
                            ->placeholder(
                                'Contoh: Garansi login selama masa berlangganan.'
                            )
                            ->rows(4),

                        Textarea::make('notes')
                            ->label('Catatan Paket')
                            ->placeholder(
                                'Contoh: Dilarang mengganti email, password, PIN, atau profil.'
                            )
                            ->rows(4),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Pengaturan Tampilan')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Paket Aktif')
                            ->helperText(
                                'Paket aktif dapat ditampilkan dan dibeli pelanggan.'
                            )
                            ->default(true)
                            ->required(),

                        Toggle::make('is_popular')
                            ->label('Paket Populer')
                            ->helperText(
                                'Tandai jika paket ingin diberi badge populer.'
                            )
                            ->default(false)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->helperText(
                                'Angka yang lebih kecil tampil lebih dahulu.'
                            )
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 3,
                    ]),
            ]);
    }
}
