<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\McuResult;
use App\Models\Participant;
use App\Models\Schedule;
use Illuminate\Http\Request;

class McuResultController extends Controller
{
    public function index(Request $request)
    {
        $query = McuResult::query()->with(['participant', 'schedule'])->orderBy('tanggal_pemeriksaan', 'desc');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('participant', function ($qry) use ($q) {
                $qry->where('nama_lengkap', 'like', "%{$q}%")->orWhere('nik_ktp', 'like', "%{$q}%");
            });
        }
        if ($request->filled('status_kesehatan')) {
            $query->where('status_kesehatan', $request->status_kesehatan);
        }
        $results = $query->paginate(15)->withQueryString();
        return view('admin.mcu-results.index', compact('results'));
    }

    public function create(Request $request)
    {
        $participants = Participant::orderBy('nama_lengkap')->get();
        $participantId = $request->get('participant_id');
        return view('admin.mcu-results.create', compact('participants', 'participantId'));
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'diagnosis' => 'nullable|string',
            'hasil_pemeriksaan' => 'nullable|string',
            'status_kesehatan' => 'required|in:Sehat,Kurang Sehat,Tidak Sehat',
            'rekomendasi' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);
        $valid['is_published'] = (bool) ($valid['is_published'] ?? false);
        $valid['uploaded_by'] = auth()->id();
        McuResult::create($valid);
        return redirect()->route('admin.mcu-results.index')->with('success', 'Hasil MCU berhasil ditambahkan.');
    }

    public function edit(McuResult $mcu_result)
    {
        $mcu_result->load(['participant', 'schedule']);
        $participants = Participant::orderBy('nama_lengkap')->get();
        $schedules = $mcu_result->participant_id
            ? Schedule::where('participant_id', $mcu_result->participant_id)->orderBy('tanggal_pemeriksaan', 'desc')->get()
            : collect();
        return view('admin.mcu-results.edit', ['mcuResult' => $mcu_result, 'participants' => $participants, 'schedules' => $schedules]);
    }

    public function update(Request $request, McuResult $mcu_result)
    {
        $valid = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'diagnosis' => 'nullable|string',
            'hasil_pemeriksaan' => 'nullable|string',
            'status_kesehatan' => 'required|in:Sehat,Kurang Sehat,Tidak Sehat',
            'rekomendasi' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);
        $mcu_result->is_published = (bool) ($valid['is_published'] ?? false);
        $mcu_result->update($valid);
        return redirect()->route('admin.mcu-results.index')->with('success', 'Hasil MCU berhasil diubah.');
    }

    public function destroy(McuResult $mcu_result)
    {
        $mcu_result->delete();
        return redirect()->route('admin.mcu-results.index')->with('success', 'Hasil MCU berhasil dihapus.');
    }
}
