<?php
// app/Http/Controllers/DetailTransaksiController.php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $items = DetailTransaksi::with('transaksi')->get();
        return view('detail-transaksi.index', compact('items'));
    }

    public function create()
    {
        $trx = Transaksi::all();
        return view('detail-transaksi.create', compact('trx'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaksi_id'         => 'required|exists:transaksi,transaksi_id',
            'total_transaksi'      => 'required|numeric',
            'total_owe_to_me'      => 'required|numeric',
            'total_pay_to_provider'=> 'required|numeric',
            'total_profit'         => 'required|numeric',
        ]);

        DetailTransaksi::create($data);
        return redirect()->route('detail-transaksi.index')->with('success', 'Detail transaksi created.');
    }

    public function show(DetailTransaksi $detailTransaksi)
    {
        return view('detail-transaksi.show', compact('detailTransaksi'));
    }

    public function edit(DetailTransaksi $detailTransaksi)
    {
        $trx = Transaksi::all();
        return view('detail-transaksi.edit', compact('detailTransaksi','trx'));
    }

    public function update(Request $request, DetailTransaksi $detailTransaksi)
    {
        $data = $request->validate([
            'total_transaksi'      => 'required|numeric',
            'total_owe_to_me'      => 'required|numeric',
            'total_pay_to_provider'=> 'required|numeric',
            'total_profit'         => 'required|numeric',
        ]);

        $detailTransaksi->update($data);
        return redirect()->route('detail-transaksi.index')->with('success', 'Detail transaksi updated.');
    }

    public function destroy(DetailTransaksi $detailTransaksi)
    {
        $detailTransaksi->delete();
        return redirect()->route('detail-transaksi.index')->with('success', 'Detail transaksi deleted.');
    }
}
