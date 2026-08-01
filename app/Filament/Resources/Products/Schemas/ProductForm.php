<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->description(
                        'Informasi utama aplikasi premium yang akan ditampilkan di katalog.'
                    )
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->placeholder('Contoh: Netflix')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                function (?string $state, callable $set): void {
                                    $set('slug', Str::slug($state ?? ''));
                                }
                            ),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('netflix')
                            ->helperText(
                                'Digunakan sebagai alamat URL detail produk.'
                            )
                            ->required()
                            ->maxLength(120)
                            ->unique(ignoreRecord: true),

                        TextInput::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->placeholder(
                                'Contoh: Paket Netflix premium dengan berbagai pilihan durasi.'
                            )
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi Lengkap')
                            ->placeholder(
                                'Tuliskan informasi lengkap mengenai produk.'
                            )
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Media Produk')
                    ->description(
                        'Upload logo aplikasi dan gambar banner untuk halaman detail.'
                    )
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo Produk')
                            ->image()
                            ->imageEditor()
                            ->directory('products/logos')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes([
                                'image/png',
                                'image/jpeg',
                                'image/webp',
                            ])
                            ->helperText(
                                'Disarankan menggunakan gambar persegi PNG atau WebP.'
                            ),

                        FileUpload::make('banner_path')
                            ->label('Banner Produk')
                            ->image()
                            ->imageEditor()
                            ->directory('products/banners')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->acceptedFileTypes([
                                'image/png',
                                'image/jpeg',
                                'image/webp',
                            ])
                            ->helperText(
                                'Disarankan menggunakan gambar horizontal.'
                            ),

                        ColorPicker::make('accent_color')
                            ->label('Warna Brand')
                            ->default('#304CB2')
                            ->helperText(
                                'Warna ini dapat digunakan pada kartu dan halaman produk.'
                            ),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Informasi Pembelian')
                    ->description(
                        'Panduan dan ketentuan yang dibaca pelanggan sebelum membeli.'
                    )
                    ->schema([
                        Textarea::make('instructions')
                            ->label('Cara Aktivasi / Penggunaan')
                            ->placeholder(
                                'Contoh: Data akun akan dikirim setelah pembayaran berhasil.'
                            )
                            ->rows(5),

                        Textarea::make('terms')
                            ->label('Syarat dan Ketentuan')
                            ->placeholder(
                                'Contoh: Dilarang mengganti email, password, atau profil.'
                            )
                            ->rows(5),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),

                Section::make('Pengaturan Tampilan')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Produk Aktif')
                            ->helperText(
                                'Produk aktif akan ditampilkan di website.'
                            )
                            ->default(true)
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Produk Unggulan')
                            ->helperText(
                                'Ditampilkan pada bagian produk pilihan.'
                            )
                            ->default(false)
                            ->required(),

                        Toggle::make('is_popular')
                            ->label('Produk Populer')
                            ->helperText(
                                'Ditampilkan pada bagian produk populer.'
                            )
                            ->default(false)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->helperText(
                                'Angka lebih kecil akan tampil lebih dahulu.'
                            )
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}
