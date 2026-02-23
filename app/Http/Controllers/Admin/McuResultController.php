<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\McuResult;
use App\Services\EmailService;
use App\Services\WhatsAppService;
use App\Models\Participant;
use App\Models\Schedule;
use App\Models\SpecialistDoctor;
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
        $diagnoses = Diagnosis::getDiagnosisList();
        $specialistDoctors = SpecialistDoctor::where('is_active', true)->orWhereNull('is_active')->orderBy('name')->get();
        return view('admin.mcu-results.create', compact('participants', 'participantId', 'diagnoses', 'specialistDoctors'));
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'hasil_pemeriksaan' => 'nullable|string',
            'status_kesehatan' => 'required|in:Sehat,Kurang Sehat,Tidak Sehat',
            'diagnosis_ids' => 'nullable|array',
            'diagnosis_ids.*' => 'integer|exists:diagnoses,id',
            'specialist_doctor_ids' => 'nullable|array',
            'specialist_doctor_ids.*' => 'integer|exists:specialist_doctors,id',
            'file_hasil' => 'nullable|array',
            'file_hasil.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,tiff|max:10240',
            'rekomendasi' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);
        $valid['is_published'] = (bool) ($valid['is_published'] ?? false);
        $valid['uploaded_by'] = auth()->id();
        $valid['hasil_pemeriksaan'] = $valid['hasil_pemeriksaan'] ?? '';
        $valid['schedule_id'] = $valid['schedule_id'] ?? null;
        $valid['rekomendasi'] = trim($valid['rekomendasi'] ?? '') ?: null;
        if ($request->hasFile('file_hasil')) {
            $paths = [];
            foreach ($request->file('file_hasil') as $file) {
                $paths[] = $file->store('mcu-results', 'public');
            }
            $valid['file_hasil_files'] = $paths;
            $valid['file_hasil'] = $paths[0] ?? null;
        }
        if (!empty($valid['diagnosis_ids'])) {
            $diagnoses = Diagnosis::whereIn('id', $valid['diagnosis_ids'])->get();
            $valid['diagnosis_list'] = $diagnoses->map(fn ($d) => $d->code ? "{$d->code} - {$d->name}" : $d->name)->toArray();
            $valid['diagnosis'] = implode(', ', $valid['diagnosis_list']);
        }
        if (!empty($valid['specialist_doctor_ids'])) {
            $valid['specialist_doctor_ids'] = array_values(array_unique(array_map('intval', $valid['specialist_doctor_ids'])));
        }
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
        $diagnoses = Diagnosis::getDiagnosisList();
        $specialistDoctors = SpecialistDoctor::where('is_active', true)->orWhereNull('is_active')->orderBy('name')->get();
        $diagnosisIds = [];
        foreach ($mcu_result->diagnosis_list ?? [$mcu_result->diagnosis] as $txt) {
            if (!$txt) continue;
            $d = Diagnosis::where('name', $txt)->orWhereRaw("CONCAT(code, ' - ', name) = ?", [$txt])->first();
            if ($d) $diagnosisIds[] = $d->id;
        }
        $specialistDoctorIds = array_map('intval', $mcu_result->specialist_doctor_ids ?? []);
        return view('admin.mcu-results.edit', [
            'mcuResult' => $mcu_result,
            'participants' => $participants,
            'schedules' => $schedules,
            'diagnoses' => $diagnoses,
            'specialistDoctors' => $specialistDoctors,
            'diagnosisIds' => $diagnosisIds,
            'specialistDoctorIds' => $specialistDoctorIds,
        ]);
    }

    public function update(Request $request, McuResult $mcu_result)
    {
        $valid = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'hasil_pemeriksaan' => 'nullable|string',
            'status_kesehatan' => 'required|in:Sehat,Kurang Sehat,Tidak Sehat',
            'diagnosis_ids' => 'nullable|array',
            'diagnosis_ids.*' => 'integer|exists:diagnoses,id',
            'specialist_doctor_ids' => 'nullable|array',
            'specialist_doctor_ids.*' => 'integer|exists:specialist_doctors,id',
            'file_hasil' => 'nullable|array',
            'file_hasil.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,tiff|max:10240',
            'rekomendasi' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);
        $mcu_result->is_published = (bool) ($valid['is_published'] ?? false);
        $valid['hasil_pemeriksaan'] = $valid['hasil_pemeriksaan'] ?? '';
        $valid['rekomendasi'] = trim($valid['rekomendasi'] ?? '') ?: null;
        if ($request->hasFile('file_hasil')) {
            $paths = [];
            foreach ($request->file('file_hasil') as $file) {
                $paths[] = $file->store('mcu-results', 'public');
            }
            $existing = $mcu_result->file_hasil_files ?? [];
            $valid['file_hasil_files'] = array_merge($existing, $paths);
            $valid['file_hasil'] = $valid['file_hasil_files'][0] ?? null;
        }
        if (!empty($valid['diagnosis_ids'])) {
            $diagnoses = Diagnosis::whereIn('id', $valid['diagnosis_ids'])->get();
            $valid['diagnosis_list'] = $diagnoses->map(fn ($d) => $d->code ? "{$d->code} - {$d->name}" : $d->name)->toArray();
            $valid['diagnosis'] = implode(', ', $valid['diagnosis_list']);
        } else {
            $valid['diagnosis'] = null;
            $valid['diagnosis_list'] = null;
        }
        if (empty($valid['specialist_doctor_ids'])) {
            $valid['specialist_doctor_ids'] = [];
        } else {
            $valid['specialist_doctor_ids'] = array_values(array_unique(array_map('intval', $valid['specialist_doctor_ids'])));
        }
        $mcu_result->update($valid);
        return redirect()->route('admin.mcu-results.index')->with('success', 'Hasil MCU berhasil diubah.');
    }

    public function destroy(McuResult $mcu_result)
    {
        $mcu_result->delete();
        return redirect()->route('admin.mcu-results.index')->with('success', 'Hasil MCU berhasil dihapus.');
    }

    public function sendEmail(McuResult $mcu_result)
    {
        $participant = $mcu_result->participant;
        if (!$participant || empty($participant->email)) {
            return redirect()->back()->withErrors(['send' => 'Email peserta tidak tersedia.']);
        }
        $emailService = new EmailService();
        if ($emailService->sendMcuResult($mcu_result)) {
            return redirect()->back()->with('success', 'Email hasil MCU berhasil dikirim ke ' . $participant->email . '.');
        }
        return redirect()->back()->withErrors(['send' => 'Gagal mengirim email. Periksa pengaturan SMTP.']);
    }

    public function sendWhatsApp(McuResult $mcu_result)
    {
        $participant = $mcu_result->participant;
        if (!$participant || empty($participant->no_telp)) {
            return redirect()->back()->withErrors(['send' => 'Nomor telepon peserta tidak tersedia.']);
        }
        $whatsappService = new WhatsAppService();
        if ($whatsappService->sendMcuResult($mcu_result)) {
            return redirect()->back()->with('success', 'WhatsApp hasil MCU berhasil dikirim ke ' . $participant->nama_lengkap . '.');
        }
        return redirect()->back()->withErrors(['send' => 'Gagal mengirim WhatsApp. Periksa pengaturan di Settings.']);
    }
}
