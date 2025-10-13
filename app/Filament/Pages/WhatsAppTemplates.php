<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Models\Setting;

class WhatsAppTemplates extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string $view = 'filament.pages.whatsapp-templates';

    protected static ?string $navigationLabel = 'WhatsApp Template';

    protected static ?string $title = 'WhatsApp Template Undangan';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }
    
    protected static string $routePath = 'whatsapp-template';

    public ?array $data = [];
    
    public static function getSlug(): string
    {
        return 'whatsapp-template';
    }

    public function mount(): void
    {
        $this->form->fill([
            'invitation_template' => Setting::getValue('whatsapp_invitation_template', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Template Undangan MCU')
                    ->description('Template WhatsApp untuk undangan Medical Check Up')
                    ->schema([
                        Placeholder::make('variables_invitation')
                            ->label('Variabel yang Tersedia')
                            ->content('
                                {nama_lengkap}, {nik_ktp}, {nrk_pegawai}, {tanggal_pemeriksaan}, 
                                {jam_pemeriksaan}, {lokasi_pemeriksaan}, {queue_number}, {skpd}, {ukpd}, {no_telp}, {email}
                            ')
                            ->columnSpanFull(),
                        
                        Textarea::make('invitation_template')
                            ->label('Template Undangan WhatsApp')
                            ->placeholder('Contoh: Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up...')
                            ->rows(10)
                            ->required()
                            ->helperText('Gunakan variabel di atas dengan format {nama_variabel}. Bisa menggunakan emoji dan enter untuk baris baru.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Preview & Tips')
                    ->description('Tips penggunaan template WhatsApp')
                    ->schema([
                        Placeholder::make('tips')
                            ->label('')
                            ->content(view('filament.pages.components.whatsapp-tips'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            // Save invitation template
            Setting::setValue(
                'whatsapp_invitation_template',
                $data['invitation_template'] ?? '',
                'text',
                'whatsapp_template',
                'Template WhatsApp Undangan'
            );

            Notification::make()
                ->title('Template WhatsApp berhasil disimpan')
                ->success()
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menyimpan template')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function resetToDefault(): void
    {
        $this->form->fill([
            'invitation_template' => 'Halo {nama_lengkap},

Anda diundang untuk mengikuti Medical Check Up pada:
📅 Tanggal: {tanggal_pemeriksaan}
🕐 Jam: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

*Catatan Penting:*
• Hadir 15 menit lebih awal
• Bawa KTP/kartu identitas
• Puasa 8 jam sebelumnya

Mohon hadir tepat waktu.

Terima kasih.',
        ]);

        Notification::make()
            ->title('Template direset ke default')
            ->info()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Simpan Template')
                ->action('save')
                ->color('success')
                ->icon('heroicon-o-check'),

            \Filament\Actions\Action::make('reset')
                ->label('Reset ke Default')
                ->action('resetToDefault')
                ->color('gray')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('Reset Template?')
                ->modalDescription('Apakah Anda yakin ingin mereset semua template ke nilai default?')
                ->modalSubmitActionLabel('Ya, Reset'),
        ];
    }
}
