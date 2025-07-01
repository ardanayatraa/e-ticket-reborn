<?php
// app/Http/Controllers/IncludeModelController.php

namespace App\Http\Controllers;

use App\Models\IncludeModel;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class IncludeModelController extends Controller
{
    public function index()
    {
        $items = IncludeModel::with('pemesanan')->get();
        return view('include-model.index', compact('items'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        return view('include-model.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pemesanan_id'       => 'required|exists:pemesanans,pemesanan_id',
            'bensin'             => 'nullable|string|max:225',
            'parkir'             => 'nullable|string|max:225',
            'sopir'              => 'nullable|string|max:225',
            'makan_siang'        => 'nullable|string|max:225',
            'makan_malam'        => 'nullable|string|max:225',
            'tiket_masuk'        => 'nullable|string|max:225',
            'status_ketersediaan'=> 'sometimes|boolean',
        ]);

        // pastikan checkbox unchecked => false
        $data['status_ketersediaan'] = $request->has('status_ketersediaan');

        IncludeModel::create($data);

        return redirect()
            ->route('include-model.index')
            ->with('success', 'Include data saved.');
    }

    public function edit(IncludeModel $include)
    {
        $includeModel=$include;
        $pemesanan = Pemesanan::all();
        return view('include-model.edit', compact('includeModel','pemesanan'));
    }

    public function update(Request $request, IncludeModel $include)
    {
        $data = $request->validate([
            'bensin'             => 'nullable|string|max:225',
            'parkir'             => 'nullable|string|max:225',
            'sopir'              => 'nullable|string|max:225',
            'makan_siang'        => 'nullable|string|max:225',
            'makan_malam'        => 'nullable|string|max:225',
            'tiket_masuk'        => 'nullable|string|max:225',
            'status_ketersediaan'=> 'sometimes|boolean',
        ]);

        $data['status_ketersediaan'] = $request->has('status_ketersediaan');

        $include->update($data);

        return redirect()
            ->route('include-model.index')
            ->with('success', 'Include data updated.');
    }

    public function destroy(IncludeModel $include)
    {
        $include->delete();

        return redirect()
            ->route('include-model.index')
            ->with('success', 'Include data deleted.');
    }
}
