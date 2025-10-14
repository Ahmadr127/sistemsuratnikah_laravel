<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marriage;
use Illuminate\Support\Facades\Auth;

class MarriageController extends Controller
{
    public function showRequestForm()
    {
        return view('marriage.request-form');
    }

    public function submitRequest(Request $request)
    {
        // Validate request
        $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_nik' => 'required|string|size:16',
            'bride_name' => 'required|string|max:255',
            'bride_nik' => 'required|string|size:16',
            'marriage_date' => 'required|date',
            'marriage_location' => 'required|string|max:255',
        ]);

        // Create new marriage request
        $marriage = Marriage::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'groom_name' => $request->groom_name,
            'groom_nik' => $request->groom_nik,
            'bride_name' => $request->bride_name,
            'bride_nik' => $request->bride_nik,
            'marriage_date' => $request->marriage_date,
            'marriage_location' => $request->marriage_location,
        ]);

        return redirect()->route('marriage.status')
            ->with('success', 'Pengajuan buku nikah berhasil disubmit.');
    }

    public function status()
    {
        $marriages = Marriage::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marriage.status', compact('marriages'));
    }
}