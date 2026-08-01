<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StoreSettings extends Page
{
    protected string $view = 'filament.pages.store-settings';

    protected static ?string $title = 'Pengaturan Toko';

    protected static ?string $navigationLabel = 'Pengaturan Toko';

    protected static ?string $slug = 'pengaturan-toko';

    protected static ?int $navigationSort = 90;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedCog6Tooth;

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function getHeading(): string
    {
        return 'Pengaturan Toko';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola informasi umum Demas Store dari satu halaman.';
    }

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => SiteSetting::getValue(
                'site_name',
                'Demas Store',
            ),
            'site_description' => SiteSetting::getValue(
                'site_description',
                'Katalog aplikasi premium dengan proses pembelian yang praktis.',
            ),
            'store_email' => SiteSetting::getValue(
                'store_email',
                'demasstore77@gmail.com',
            ),
            'whatsapp_number' => SiteSetting::getValue(
                'whatsapp_number',
                '',
            ),
            'instagram_url' => SiteSetting::getValue(
                'instagram_url',
                '',
            ),
            'tiktok_url' => SiteSetting::getValue(
                'tiktok_url',
                '',
            ),
            'youtube_url' => SiteSetting::getValue(
                'youtube_url',
                '',
            ),
            'service_fee' => SiteSetting::getValue(
                'service_fee',
                0,
            ),
            'footer_text' => SiteSetting::getValue(
                'footer_text',
                'Demas Store. All rights reserved.',
            ),
            'maintenance_mode' => SiteSetting::getValue(
                'maintenance_mode',
                false,
            ),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    TextInput::make('site_name')
                        ->label('Nama Toko')
                        ->required()
                        ->maxLength(100),

                    Textarea::make('site_description')
                        ->label('Deskripsi Toko')
                        ->rows(4)
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('store_email')
                        ->label('Email Toko')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    TextInput::make('whatsapp_number')
                        ->label('Nomor WhatsApp')
                        ->helperText(
                            'Gunakan format 62 tanpa tanda +, spasi, atau angka 0 di awal.',
                        )
                        ->placeholder('6281234567890')
                        ->tel()
                        ->maxLength(20),

                    TextInput::make('instagram_url')
                        ->label('Instagram')
                        ->url()
                        ->placeholder('https://instagram.com/demasstore'),

                    TextInput::make('tiktok_url')
                        ->label('TikTok')
                        ->url()
                        ->placeholder('https://tiktok.com/@demasstore'),

                    TextInput::make('youtube_url')
                        ->label('YouTube')
                        ->url()
                        ->placeholder('https://youtube.com/@demasstore'),

                    TextInput::make('service_fee')
                        ->label('Biaya Layanan')
                        ->numeric()
                        ->prefix('Rp')
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('footer_text')
                        ->label('Teks Footer')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Toggle::make('maintenance_mode')
                        ->label('Mode Maintenance')
                        ->helperText(
                            'Aktifkan hanya saat website sedang dalam perbaikan.',
                        )
                        ->inline(false),
                ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Simpan Pengaturan')
                                ->submit('save')
                                ->icon(Heroicon::OutlinedCheck)
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::setValue('site_name', $data['site_name']);
        SiteSetting::setValue(
            'site_description',
            $data['site_description'],
        );
        SiteSetting::setValue('store_email', $data['store_email']);
        SiteSetting::setValue(
            'whatsapp_number',
            $data['whatsapp_number'] ?? '',
        );
        SiteSetting::setValue(
            'instagram_url',
            $data['instagram_url'] ?? '',
        );
        SiteSetting::setValue(
            'tiktok_url',
            $data['tiktok_url'] ?? '',
        );
        SiteSetting::setValue(
            'youtube_url',
            $data['youtube_url'] ?? '',
        );
        SiteSetting::setValue(
            'service_fee',
            (int) ($data['service_fee'] ?? 0),
            'integer',
        );
        SiteSetting::setValue(
            'footer_text',
            $data['footer_text'],
        );
        SiteSetting::setValue(
            'maintenance_mode',
            (bool) ($data['maintenance_mode'] ?? false),
            'boolean',
        );

        Notification::make()
            ->title('Pengaturan toko berhasil disimpan')
            ->success()
            ->send();
    }
}
