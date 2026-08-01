<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description(
                        'Kategori digunakan untuk mengelompokkan produk seperti Streaming, AI, Musik, dan Design.'
                    )
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Streaming')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                $set('slug', Str::slug($state ?? ''));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('streaming')
                            ->helperText('Digunakan pada alamat URL kategori.')
                            ->required()
                            ->maxLength(120)
                            ->unique(ignoreRecord: true),

                        TextInput::make('icon')
                            ->label('Ikon')
                            ->placeholder('Contoh: heroicon-o-play')
                            ->helperText('Opsional. Untuk sementara boleh dikosongkan.')
                            ->maxLength(100),

                        ColorPicker::make('color')
                            ->label('Warna Kategori')
                            ->default('#304CB2'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->helperText('Angka yang lebih kecil tampil lebih dahulu.')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Kategori Aktif')
                            ->helperText('Kategori nonaktif tidak akan ditampilkan di website.')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }
}
