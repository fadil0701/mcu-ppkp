<?php

namespace App\Filament\Pages;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantsExport;
use App\Exports\SchedulesExport;
use App\Exports\McuResultsExport;
use App\Exports\DiagnosesExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Reports extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Reports & Analytics';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.reports';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Report Filters')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(now()->startOfMonth()),
                        
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->default(now()),
                        
                        Select::make('skpd')
                            ->options(Participant::distinct()->pluck('skpd', 'skpd'))
                            ->label('SKPD (Optional)')
                            ->placeholder('All SKPDs'),
                        
                        Select::make('status_pegawai')
                            ->options([
                                'CPNS' => 'CPNS',
                                'PNS' => 'PNS',
                                'PPPK' => 'PPPK',
                            ])
                            ->label('Employee Status (Optional)')
                            ->placeholder('All Statuses'),
                    ])
                    ->columns(4),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_participant_report')
                ->label('Generate Participant Report')
                ->icon('heroicon-o-users')
                ->color('success')
                ->action('generateParticipantReport'),
            
            Action::make('generate_schedule_report')
                ->label('Generate Schedule Report')
                ->icon('heroicon-o-calendar')
                ->color('info')
                ->action('generateScheduleReport'),
            
            Action::make('generate_mcu_report')
                ->label('Generate MCU Results Report')
                ->icon('heroicon-o-document-text')
                ->color('warning')
                ->action('generateMcuReport'),
            
            Action::make('generate_diagnosis_report')
                ->label('Generate Diagnosis Report')
                ->icon('heroicon-o-chart-bar')
                ->color('danger')
                ->action('generateDiagnosisReport'),
        ];
    }

    public function generateParticipantReport(): void
    {
        $data = $this->form->getState();
        
        $query = Participant::query();
        
        if (!empty($data['skpd'])) {
            $query->where('skpd', $data['skpd']);
        }
        
        if (!empty($data['status_pegawai'])) {
            $query->where('status_pegawai', $data['status_pegawai']);
        }
        
        $participants = $query->get();
        
        // Generate report logic here
        $totalParticipants = $participants->count();
        $bySkpd = $participants->groupBy('skpd')->map->count();
        $byStatus = $participants->groupBy('status_pegawai')->map->count();
        $byGender = $participants->groupBy('jenis_kelamin')->map->count();
        $byAgeCategory = $participants->groupBy('kategori_umur')->map->count();
        
        Notification::make()
            ->title('Participant Report Generated')
            ->body("Total Participants: {$totalParticipants}")
            ->success()
            ->send();
    }

    public function generateScheduleReport(): void
    {
        $data = $this->form->getState();
        
        $query = Schedule::query();
        
        if (!empty($data['start_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $data['start_date']);
        }
        
        if (!empty($data['end_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $data['end_date']);
        }
        
        if (!empty($data['skpd'])) {
            $query->whereHas('participant', function ($q) use ($data) {
                $q->where('skpd', $data['skpd']);
            });
        }
        
        $schedules = $query->get();
        
        // Generate report logic here
        $totalScheduled = $schedules->count();
        $byStatus = $schedules->groupBy('status')->map->count();
        $bySkpd = $schedules->groupBy('participant.skpd')->map->count();
        
        Notification::make()
            ->title('Schedule Report Generated')
            ->body("Total Scheduled: {$totalScheduled}")
            ->success()
            ->send();
    }

    public function generateMcuReport(): void
    {
        $data = $this->form->getState();
        
        $query = McuResult::query();
        
        if (!empty($data['start_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $data['start_date']);
        }
        
        if (!empty($data['end_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $data['end_date']);
        }
        
        if (!empty($data['skpd'])) {
            $query->whereHas('participant', function ($q) use ($data) {
                $q->where('skpd', $data['skpd']);
            });
        }
        
        $results = $query->get();
        
        // Generate report logic here
        $totalResults = $results->count();
        $byHealthStatus = $results->groupBy('status_kesehatan')->map->count();
        $bySkpd = $results->groupBy('participant.skpd')->map->count();
        
        Notification::make()
            ->title('MCU Results Report Generated')
            ->body("Total Results: {$totalResults}")
            ->success()
            ->send();
    }

    public function generateDiagnosisReport(): void
    {
        $data = $this->form->getState();
        
        $query = McuResult::query()->whereNotNull('diagnosis');
        
        if (!empty($data['start_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $data['start_date']);
        }
        
        if (!empty($data['end_date'])) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $data['end_date']);
        }
        
        $results = $query->get();
        
        // Generate report logic here
        $diagnoses = $results->groupBy('diagnosis')->map->count()->sortDesc();
        
        Notification::make()
            ->title('Diagnosis Report Generated')
            ->body("Top diagnosis: " . $diagnoses->keys()->first())
            ->success()
            ->send();
    }

    public function getTitle(): string
    {
        return 'MCU Reports & Analytics';
    }

    public function download(string $type)
    {
        switch ($type) {
            case 'participants':
                $filters = [
                    'start_date' => request('start_date'),
                    'end_date' => request('end_date'),
                    'skpd' => request('skpd'),
                    'status_pegawai' => request('status_pegawai'),
                ];
                $filename = 'participants-' . now()->format('Ymd_His') . '.xlsx';
                return Excel::download(new ParticipantsExport($filters), $filename);

            case 'schedules':
                $filters = [
                    'start_date' => request('start_date'),
                    'end_date' => request('end_date'),
                    'skpd' => request('skpd'),
                ];
                $filename = 'schedules-' . now()->format('Ymd_His') . '.xlsx';
                return Excel::download(new SchedulesExport($filters), $filename);

            case 'mcu':
                $filters = [
                    'start_date' => request('start_date'),
                    'end_date' => request('end_date'),
                    'skpd' => request('skpd'),
                ];
                $filename = 'mcu-results-' . now()->format('Ymd_His') . '.xlsx';
                return Excel::download(new McuResultsExport($filters), $filename);

            case 'diagnoses':
                $filters = [
                    'start_date' => request('start_date'),
                    'end_date' => request('end_date'),
                    'skpd' => request('skpd'),
                ];
                $filename = 'diagnoses-' . now()->format('Ymd_His') . '.xlsx';
                return Excel::download(new DiagnosesExport($filters), $filename);

            default:
                abort(404, 'Report type not supported');
        }
    }
}
