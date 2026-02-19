<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WhatsAppTemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()?->hasRole('super_admin')) {
                abort(403, 'Hanya super admin yang dapat mengakses WhatsApp Template.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $invitation_template = Setting::getValue('whatsapp_invitation_template', '');
        return view('admin.whatsapp-templates.index', compact('invitation_template'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'invitation_template' => 'required|string',
        ]);
        try {
            Setting::setValue(
                'whatsapp_invitation_template',
                $request->invitation_template,
                'text',
                'whatsapp_template',
                'Template WhatsApp Undangan'
            );
            return redirect()->route('admin.whatsapp-templates.index')->with('success', 'Template WhatsApp berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function reset()
    {
        $default = "Halo {nama_lengkap},\n\nAnda diundang untuk mengikuti Medical Check Up pada:\n📅 Tanggal: {tanggal_pemeriksaan}\n🕐 Jam: {jam_pemeriksaan}\n📍 Lokasi: {lokasi_pemeriksaan}\n🎫 Nomor Antrian: {queue_number}\n\n*Catatan Penting:*\n• Hadir 15 menit lebih awal\n• Bawa KTP/kartu identitas\n• Puasa 8 jam sebelumnya\n\nMohon hadir tepat waktu.\n\nTerima kasih.";
        Setting::setValue('whatsapp_invitation_template', $default, 'text', 'whatsapp_template', 'Template WhatsApp Undangan');
        return redirect()->route('admin.whatsapp-templates.index')->with('success', 'Template direset ke default.');
    }
}
