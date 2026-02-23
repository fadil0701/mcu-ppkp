<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'type' => 'required|in:string,number,boolean,json,textarea',
            'group' => 'required|in:general,email,whatsapp,mcu,system',
            'value' => 'nullable|string',
            'description' => 'nullable|string|max:500',
        ]);
        Setting::setValue(
            $valid['key'],
            $valid['value'] ?? '',
            $valid['type'],
            $valid['group'],
            $valid['description'] ?? null
        );
        return redirect()->route('admin.settings.index')->with('success', 'Setting berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
        $query = Setting::query()->orderBy('group')->orderBy('key');
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qry) use ($q) {
                $qry->where('key', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }
        $settings = $query->paginate(15)->withQueryString();
        return view('admin.settings.index', compact('settings'));
    }

    public function edit(Setting $setting)
    {
        $value = $setting->is_encrypted ? '(terenkripsi)' : $setting->value;
        return view('admin.settings.edit', compact('setting', 'value'));
    }

    public function update(Request $request, Setting $setting)
    {
        if ($setting->is_encrypted) {
            return redirect()->route('admin.settings.index')->with('error', 'Setting terenkripsi tidak dapat diubah dari sini.');
        }
        $request->validate(['value' => 'required|string']);
        $setting->value = $request->value;
        $setting->save();
        return redirect()->route('admin.settings.index')->with('success', 'Setting berhasil diubah.');
    }

    /**
     * Template email untuk mengirim hasil MCU (fallback bila tidak ada EmailTemplate tipe mcu_result)
     */
    public function emailResultTemplate()
    {
        if (!auth()->user()?->hasRole('super_admin')) {
            abort(403, 'Hanya super admin yang dapat mengakses halaman ini.');
        }
        $defaultSubject = 'Hasil MCU Anda Tersedia';
        $defaultBody = "Kepada {participant_name},\n\nHasil MCU Anda untuk pemeriksaan tanggal {tanggal_pemeriksaan} telah tersedia.\n\nStatus Kesehatan: {status_kesehatan}\nDiagnosis: {diagnosis}\n\nSilakan login ke {hasil_url} untuk melihat dan mendownload hasil lengkap.\n\nTerima kasih.";
        $subject = Setting::getValue('email_result_subject', $defaultSubject) ?: $defaultSubject;
        $body = Setting::getValue('email_result_template', $defaultBody) ?: $defaultBody;
        return view('admin.settings.email-result-template', compact('subject', 'body'));
    }

    public function updateEmailResultTemplate(Request $request)
    {
        if (!auth()->user()?->hasRole('super_admin')) {
            abort(403, 'Hanya super admin yang dapat mengakses halaman ini.');
        }
        $request->validate([
            'email_result_subject' => 'required|string|max:255',
            'email_result_template' => 'required|string',
        ]);
        Setting::setValue('email_result_subject', $request->email_result_subject, 'text', 'email_template', 'Subject email notifikasi hasil MCU');
        Setting::setValue('email_result_template', $request->email_result_template, 'text', 'email_template', 'Body email notifikasi hasil MCU');
        return redirect()->route('admin.settings.email-result-template')->with('success', 'Template email hasil MCU berhasil disimpan.');
    }
}
