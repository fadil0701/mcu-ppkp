<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RescheduleCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()?->hasRole('super_admin')) {
                abort(403, 'Hanya super admin yang dapat mengakses Permintaan Reschedule.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Schedule::query()
            ->where('reschedule_requested', true)
            ->with('participant')
            ->latest('reschedule_requested_at');

        if ($request->filled('skpd')) {
            $query->whereHas('participant', fn ($q) => $q->where('skpd', $request->skpd));
        }
        if ($request->filled('from')) {
            $query->whereDate('reschedule_requested_at', '>=', $request->from);
        }
        if ($request->filled('until')) {
            $query->whereDate('reschedule_requested_at', '<=', $request->until);
        }

        $schedules = $query->paginate(15)->withQueryString();
        $skpds = \App\Models\Participant::distinct()->pluck('skpd', 'skpd');
        return view('admin.reschedule-center.index', compact('schedules', 'skpds'));
    }

    public function approve(Schedule $schedule)
    {
        if (!$schedule->reschedule_requested) {
            return redirect()->route('admin.reschedule-center.index')->with('error', 'Jadwal ini tidak memiliki permintaan reschedule.');
        }
        $schedule->tanggal_pemeriksaan = $schedule->reschedule_new_date ?? $schedule->tanggal_pemeriksaan;
        $schedule->jam_pemeriksaan = $schedule->reschedule_new_time ?? $schedule->jam_pemeriksaan;
        $max = Schedule::whereDate('tanggal_pemeriksaan', $schedule->tanggal_pemeriksaan)->where('id', '!=', $schedule->id)->max('queue_number');
        $schedule->queue_number = ((int) $max) + 1;
        $schedule->reschedule_requested = false;
        $schedule->reschedule_new_date = null;
        $schedule->reschedule_new_time = null;
        $schedule->reschedule_reason = null;
        $schedule->reschedule_requested_at = null;
        $schedule->save();
        return redirect()->route('admin.reschedule-center.index')->with('success', 'Permintaan reschedule disetujui.');
    }

    public function reject(Schedule $schedule)
    {
        if (!$schedule->reschedule_requested) {
            return redirect()->route('admin.reschedule-center.index')->with('error', 'Jadwal ini tidak memiliki permintaan reschedule.');
        }
        $schedule->update([
            'reschedule_requested' => false,
            'reschedule_new_date' => null,
            'reschedule_new_time' => null,
            'reschedule_reason' => null,
            'reschedule_requested_at' => null,
        ]);
        return redirect()->route('admin.reschedule-center.index')->with('success', 'Permintaan reschedule ditolak.');
    }
}
