<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kua;
use Illuminate\Http\Request;

class KuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuas = Kua::orderBy('order', 'asc')->get();
        return view('admin.kuas.index', compact('kuas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kuas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours' => 'nullable|string|max:255',
            'google_maps_link' => 'nullable|url',
            'google_maps_embed' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Kua::create($validated);

        return redirect()->route('admin.kuas.index')
            ->with('success', 'Data KUA berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kua = Kua::findOrFail($id);
        return view('admin.kuas.show', compact('kua'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kua = Kua::findOrFail($id);
        return view('admin.kuas.edit', compact('kua'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kua = Kua::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours' => 'nullable|string|max:255',
            'google_maps_link' => 'nullable|url',
            'google_maps_embed' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $kua->update($validated);

        return redirect()->route('admin.kuas.index')
            ->with('success', 'Data KUA berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kua = Kua::findOrFail($id);
        $kua->delete();

        return redirect()->route('admin.kuas.index')
            ->with('success', 'Data KUA berhasil dihapus.');
    }
}
