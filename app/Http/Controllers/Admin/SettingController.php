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

    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
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
}
