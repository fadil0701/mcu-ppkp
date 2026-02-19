<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Schedule;
use App\Models\McuResult;
use App\Services\QueryOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Satu dashboard untuk semua role: tampilan berbeda untuk admin vs peserta.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->participantDashboard();
    }

    /**
     * Data dan view untuk dashboard admin (tanpa Filament).
     */
    protected function adminDashboard()
    {
        $stats = QueryOptimizationService::getDashboardStats();
        $topSkpds = QueryOptimizationService::getSkpdStats(5);
        $chartData = QueryOptimizationService::getChartData(6);
        $healthStats = QueryOptimizationService::getHealthStatusDistribution();

        // Data untuk line chart (6 bulan)
        $months = collect();
        $participantsData = $chartData['participantsData'];
        $mcuResultsData = $chartData['mcuResultsData'];
        $participantsByMonth = [];
        $mcuResultsByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $months->push($date->format('M Y'));
            $participantsByMonth[] = $participantsData->get($monthKey, 0);
            $mcuResultsByMonth[] = $mcuResultsData->get($monthKey, 0);
        }

        // Tabel konfirmasi hadir hari ini
        $confirmedToday = Schedule::query()
            ->with(['participant:id,nama_lengkap,nik_ktp'])
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->where('status', 'Terjadwal')
            ->where('participant_confirmed', true)
            ->orderBy('jam_pemeriksaan')
            ->limit(30)
            ->get();

        return view('dashboard.admin', [
            'stats' => $stats,
            'topSkpds' => $topSkpds,
            'chartLabels' => $months->toArray(),
            'participantsByMonth' => $participantsByMonth,
            'mcuResultsByMonth' => $mcuResultsByMonth,
            'healthStats' => $healthStats,
            'confirmedToday' => $confirmedToday,
        ]);
    }

    /**
     * Data dan view untuk dashboard peserta (reuse logic ClientController).
     */
    protected function participantDashboard()
    {
        $user = Auth::user();
        $participant = null;
        $schedules = collect();
        $mcuResults = collect();

        $todayQueueTotal = cache()->remember('today_queue_total_' . now()->toDateString(), 300, function () {
            return Schedule::whereDate('tanggal_pemeriksaan', now()->toDateString())
                ->where('status', 'Terjadwal')
                ->count();
        });

        if ($user->nik_ktp) {
            $participant = Participant::where('nik_ktp', $user->nik_ktp)->first();
            if ($participant) {
                $schedules = $participant->schedules()->orderBy('tanggal_pemeriksaan', 'desc')->get();
                $mcuResults = $participant->mcuResults()
                    ->where('is_published', true)
                    ->orderBy('tanggal_pemeriksaan', 'desc')
                    ->get();
            }
        }

        return view('dashboard.participant', compact('participant', 'schedules', 'mcuResults', 'todayQueueTotal'));
    }
}
