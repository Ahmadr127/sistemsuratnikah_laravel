<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;

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

        return view('home', compact('data'));
    }
}
