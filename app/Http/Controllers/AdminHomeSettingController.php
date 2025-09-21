<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;

class AdminHomeSettingController extends Controller
{
    public function edit()
    {
        $setting = HomeSetting::first();
        $default = config('home');

        // Jika belum ada di DB, pakai default untuk pertama kali tampil
        if (!$setting) {
            $setting = new HomeSetting([
                'title' => $default['title'] ?? '',
                'subtitle' => $default['subtitle'] ?? '',
                'features' => $default['features'] ?? [],
                'stats' => $default['stats'] ?? [],
            ]);
        }

        return view('admin.home-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'features' => 'nullable',
            'stats' => 'nullable',
        ]);

        // features dan stats dari form berupa JSON string, decode aman
        $features = $this->safeJsonDecode($request->input('features')) ?? [];
        $stats = $this->safeJsonDecode($request->input('stats')) ?? [];

        $setting = HomeSetting::first();
        if (!$setting) {
            $setting = new HomeSetting();
        }

        $setting->fill([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'features' => $features,
            'stats' => $stats,
        ]);
        $setting->save();

        return redirect()->route('admin.home-settings.edit')->with('status', 'Pengaturan home berhasil disimpan.');
    }

    private function safeJsonDecode(?string $json)
    {
        if (!$json) {
            return null;
        }
        $decoded = json_decode($json, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }
}


