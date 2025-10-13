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

class EmailTemplates extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $view = 'filament.pages.email-templates';

    protected static ?string $navigationLabel = 'Email Template';

    protected static ?string $title = 'Email Template Undangan';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }
    
    protected static string $routePath = 'email-template';

    public ?array $data = [];
    
    public static function getSlug(): string
    {
        return 'email-template';
    }

    public function mount(): void
    {
        $this->form->fill([
            'email_invitation_subject' => Setting::getValue('email_invitation_subject', ''),
            'email_invitation_template' => Setting::getValue('email_invitation_template', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Template Email Undangan MCU')
                    ->description('Template email untuk undangan Medical Check Up')
                    ->schema([
                        TextInput::make('email_invitation_subject')
                            ->label('Subject Email')
                            ->placeholder('Contoh: Undangan Medical Check Up')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Subject/judul email yang akan dikirim')
                            ->columnSpanFull(),

                        Placeholder::make('variables_invitation')
                            ->label('Variabel yang Tersedia')
                            ->content('
                                {nama_lengkap}, {nik_ktp}, {nrk_pegawai}, {tanggal_pemeriksaan}, 
                                {jam_pemeriksaan}, {lokasi_pemeriksaan}, {queue_number}, {skpd}, {ukpd}, {no_telp}, {email}
                            ')
                            ->columnSpanFull(),
                        
                        Textarea::make('email_invitation_template')
                            ->label('Isi Email')
                            ->placeholder('Contoh: Kepada Yth. {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up...')
                            ->rows(12)
                            ->required()
                            ->helperText('Isi email dalam format teks biasa. Gunakan variabel dengan format {nama_variabel}. Baris baru akan dipertahankan.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Preview & Tips')
                    ->description('Tips penggunaan template email')
                    ->schema([
                        Placeholder::make('tips')
                            ->label('')
                            ->content(view('filament.pages.components.email-tips'))
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
            // Save email subject
            Setting::setValue(
                'email_invitation_subject',
                $data['email_invitation_subject'] ?? '',
                'string',
                'email_template',
                'Subject Email Undangan'
            );

            // Save email template
            Setting::setValue(
                'email_invitation_template',
                $data['email_invitation_template'] ?? '',
                'text',
                'email_template',
                'Template Email Undangan'
            );

            Notification::make()
                ->title('Template Email berhasil disimpan')
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
            'email_invitation_subject' => 'Undangan Medical Check Up',
            'email_invitation_template' => 'Kepada Yth. {nama_lengkap}

Dengan hormat,

Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up yang akan dilaksanakan pada:

Tanggal: {tanggal_pemeriksaan}
Waktu: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Nomor Antrian: {queue_number}

CATATAN PENTING:
1. Harap hadir 15 menit sebelum jadwal
2. Membawa KTP/kartu identitas
3. Puasa 8 jam sebelum pemeriksaan
4. Menggunakan pakaian yang nyaman

Mohon konfirmasi kehadiran Anda melalui sistem atau hubungi kami jika berhalangan hadir.

Terima kasih atas perhatian dan kerjasamanya.

Hormat kami,
Tim Medical Check Up',
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
                ->modalDescription('Apakah Anda yakin ingin mereset template ke nilai default?')
                ->modalSubmitActionLabel('Ya, Reset'),
        ];
    }
}
