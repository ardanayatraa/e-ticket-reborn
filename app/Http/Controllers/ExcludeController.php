<?php
// app/Http/Controllers/ExcludeController.php

namespace App\Http\Controllers;

use App\Models\Exclude;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class ExcludeController extends Controller
{
    public function index()
    {
        $items = Exclude::with('pemesanan')->get();
        return view('exclude.index', compact('items'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        return view('exclude.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        // Validasi
        $data = $request->validate([
            'pemesanan_id'        => 'required|exists:pemesanans,pemesanan_id',
            'bensin'              => 'nullable|string|max:225',
            'parkir'              => 'nullable|string|max:225',
            'sopir'               => 'nullable|string|max:225',
            'makan_siang'         => 'nullable|string|max:225',
            'makan_malam'         => 'nullable|string|max:225',
            'tiket_masuk'         => 'nullable|string|max:225',
            'status_ketersediaan' => 'sometimes|boolean',
        ]);

        // Pastikan checkbox unchecked = false
        $data['status_ketersediaan'] = $request->has('status_ketersediaan');

        Exclude::create($data);

        return redirect()
            ->route('exclude.index')
            ->with('success', 'Exclude data saved.');
    }

    public function edit(Exclude $exclude)
    {
        $pemesanan = Pemesanan::all();
        return view('exclude.edit', compact('exclude','pemesanan'));
    }

    public function update(Request $request, Exclude $exclude)
    {
        $data = $request->validate([
            'bensin'              => 'nullable|string|max:225',
            'parkir'              => 'nullable|string|max:225',
            'sopir'               => 'nullable|string|max:225',
            'makan_siang'         => 'nullable|string|max:225',
            'makan_malam'         => 'nullable|string|max:225',
            'tiket_masuk'         => 'nullable|string|max:225',
            'status_ketersediaan' => 'sometimes|boolean',
        ]);

        $data['status_ketersediaan'] = $request->has('status_ketersediaan');

        $exclude->update($data);

        return redirect()
            ->route('exclude.index')
            ->with('success', 'Exclude data updated.');
    }

    public function destroy(Exclude $exclude)
    {
        $exclude->delete();
        return redirect()
            ->route('exclude.index')
            ->with('success', 'Exclude data deleted.');
    }
}
