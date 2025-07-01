<?php
// app/Http/Controllers/SopirController.php

namespace App\Http\Controllers;

use App\Models\Sopir;
use Illuminate\Http\Request;

class SopirController extends Controller
{
    public function index()
    {
        $sopirs = Sopir::all();
        return view('sopir.index', compact('sopirs'));
    }

    public function create()
    {
        return view('sopir.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sopir' => 'required|string|max:255',
            'nomor_ktp'  => 'required|string',
            'sim'        => 'nullable|string',
            'foto'       => 'nullable|image',
            'umur'       => 'nullable|integer',
            'alamat'     => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sopir','public');

        }

        Sopir::create($data);
        return redirect()->route('sopir.index')->with('success', 'sopir created.');
    }

    public function show(Sopir $sopir)
    {
        return view('sopir.show', compact('sopir'));
    }

    public function edit(Sopir $sopir)
    {
        return view('sopir.edit', compact('sopir'));
    }

    public function update(Request $request, Sopir $sopir)
    {
        $data = $request->validate([
            'nama_sopir' => 'required|string|max:255',
            'nomor_ktp'  => 'required|string',
            'sim'        => 'nullable|string',
            'foto'       => 'nullable|image',
            'umur'       => 'nullable|integer',
            'alamat'     => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sopir');
        }

        $sopir->update($data);
        return redirect()->route('sopir.index')->with('success', 'sopir updated.');
    }

    public function destroy(Sopir $sopir)
    {
        $sopir->delete();
        return redirect()->route('sopir.index')->with('success', 'sopir deleted.');
    }
}
