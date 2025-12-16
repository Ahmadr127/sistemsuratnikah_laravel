<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\Kua;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil dari DB jika ada, fallback ke config
        $setting = HomeSetting::first();
        if ($setting) {
            $data = [
                'title' => $setting->title,
                'subtitle' => $setting->subtitle,
                'features' => $setting->features ?? [],
                'stats' => $setting->stats ?? [],
            ];
        } else {
            $data = config('home');
        }

        // Ambil data KUA yang aktif dan diurutkan
        $kuas = Kua::active()->ordered()->get();

        return view('home', compact('data', 'kuas'));
    }
}
