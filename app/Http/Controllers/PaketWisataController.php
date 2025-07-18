<?php

namespace App\Http\Controllers;

use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\PaketWisata;
use App\Models\IncludeModel;
use App\Models\Exclude;
use App\Models\PointSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaketWisataController extends Controller
{
    public function index()
    {
        $pakets = PaketWisata::with(['include', 'exclude'])->get();
        return view('paket-wisata.index', compact('pakets'));
    }

    public function create()
    {
        return view('paket-wisata.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:255',
            'tempat' => 'required|string',
            'deskripsi' => 'required|string',
            'durasi' => 'required|integer|min:1',
            'max_duration' => 'required|integer|min:1|max:9',
            'harga'  => 'required|numeric|min:0',
            'foto'   => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Generate slug
            $data['slug'] = Str::slug($data['judul']);

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('paket-wisata', 'public');
            }

            // Handle gallery upload
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('paket-wisata/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            }

            // Create paket wisata
            $paketWisata = PaketWisata::create($data);

            // Handle include/exclude
            $includeFields = ['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk'];

            $includeData = [
                'paketwisata_id' => $paketWisata->paketwisata_id,
                'status_ketersediaan' => 1
            ];

            $excludeData = [
                'paketwisata_id' => $paketWisata->paketwisata_id,
                'status_ketersediaan' => 1
            ];

            // Process include/exclude based on checkbox selections
            foreach ($includeFields as $field) {
                if ($request->has("include.$field") && $request->input("include.$field") == '1') {
                    $includeData[$field] = 1;
                    $excludeData[$field] = 0;
                } else {
                    $includeData[$field] = 0;
                    $excludeData[$field] = 1;
                }
            }

            // Create include and exclude records
            IncludeModel::create($includeData);
            Exclude::create($excludeData);

            DB::commit();

            return redirect()
                ->route('paket-wisata.index')
                ->with('success', 'Paket wisata berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();

            // Clean up uploaded files if error
            if (isset($data['foto']) && Storage::disk('public')->exists($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }

            if (isset($data['gallery'])) {
                foreach ($data['gallery'] as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

 public function show($slug)
{
    $paket = PaketWisata::where('slug', $slug)
        ->with(['include', 'exclude'])
        ->firstOrFail();
    $mobil = Mobil::all();

    // Ambil pengaturan poin untuk keuntungan member
    $pointSettings = PointSetting::all()->keyBy('key');

    // Jika request AJAX, return view detail saja
    if (request()->ajax()) {
        return view('paket-wisata.detail-content', compact('paket', 'mobil', 'pointSettings'));
    }

    // Jika bukan AJAX, return halaman detail lengkap
    return view('paket-wisata.detail', compact('paket', 'mobil', 'pointSettings'));
}

    // PERBAIKAN: Hapus dd(1) dan gunakan parameter yang konsisten
    public function edit($id)
{
    $paketwisata = PaketWisata::findOrFail($id);
    $paketwisata->load(['include', 'exclude']);

    return view('paket-wisata.edit', ['paketwisata' => $paketwisata]);
}

    // PERBAIKAN: Gunakan parameter yang konsisten
    public function update(Request $request, $id)
{

    $paketwisata = PaketWisata::where('slug',$id)->first();

    $data = $request->validate([
        'judul'  => 'required|string|max:255',
        'tempat' => 'required|string',
        'deskripsi' => 'required|string',
        'durasi' => 'required|integer|min:1',
        'max_duration' => 'required|integer|min:1|max:9',
        'harga'  => 'required|numeric|min:0',
        'foto'   => 'nullable|image|max:2048',
        'gallery.*' => 'nullable|image|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Update slug jika judul berubah
        if ($paketwisata->judul !== $data['judul']) {
            $data['slug'] = Str::slug($data['judul']);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($paketwisata->foto) {
                Storage::disk('public')->delete($paketwisata->foto);
            }
            $data['foto'] = $request->file('foto')->store('paket-wisata', 'public');
        }

        // Handle gallery update
        if ($request->hasFile('gallery')) {
            // Hapus gallery lama
            if ($paketwisata->gallery) {
                foreach ($paketwisata->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('paket-wisata/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Update paket wisata
        $paketwisata->update($data);

        // Update include/exclude logic...
        $includeFields = ['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk'];

        $includeData = [];
        $excludeData = [];

        foreach ($includeFields as $field) {
            if ($request->has("include.$field") && $request->input("include.$field") == '1') {
                $includeData[$field] = 1;
                $excludeData[$field] = 0;
            } else {
                $includeData[$field] = 0;
                $excludeData[$field] = 1;
            }
        }

        // Update or create include
        if ($paketwisata->include) {
            $paketwisata->include->update($includeData);
        } else {
            $includeData['paketwisata_id'] = $paketwisata->paketwisata_id;
            $includeData['status_ketersediaan'] = 1;
            IncludeModel::create($includeData);
        }

        // Update or create exclude
        if ($paketwisata->exclude) {
            $paketwisata->exclude->update($excludeData);
        } else {
            $excludeData['paketwisata_id'] = $paketwisata->paketwisata_id;
            $excludeData['status_ketersediaan'] = 1;
            Exclude::create($excludeData);
        }

        DB::commit();

        return redirect()
            ->route('paket-wisata.index')
            ->with('success', 'Paket wisata berhasil diperbarui.');

    } catch (\Exception $e) {
        DB::rollback();

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    }
}

    // PERBAIKAN: Gunakan parameter yang konsisten
    public function destroy($id)
{
    $paketwisata = PaketWisata::findOrFail($id);

    DB::beginTransaction();

    try {
        // Delete include and exclude first
        if ($paketwisata->include) {
            $paketwisata->include->delete();
        }

        if ($paketwisata->exclude) {
            $paketwisata->exclude->delete();
        }

        // Delete files
        if ($paketwisata->foto) {
            Storage::disk('public')->delete($paketwisata->foto);
        }

        if ($paketwisata->gallery) {
            foreach ($paketwisata->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Delete paket wisata
        $paketwisata->delete();

        DB::commit();

        return redirect()
            ->route('paket-wisata.index')
            ->with('success', 'Paket wisata berhasil dihapus.');

    } catch (\Exception $e) {
        DB::rollback();

        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
}
      public function list()
    {
        $paket = PaketWisata::with(['include', 'exclude'])
            ->orderBy('created_at', 'desc')
            ->get();
        $mobil = Mobil::all();

        // Ambil pengaturan poin untuk keuntungan member
        $pointSettings = PointSetting::all()->keyBy('key');

        return view('paket-wisata.landing-page', compact('paket', 'mobil', 'pointSettings'));
    }

    public function check(Request $request)
    {
        $date = $request->query('date');
        $currentTime = Carbon::now();
        $requestDate = Carbon::parse($date);

        // Cek pembatasan waktu booking untuk besok
        $tomorrow = Carbon::tomorrow();
        if ($requestDate->isSameDay($tomorrow) && $currentTime->hour >= 17) {
            return response()->json([]);
        }

        // Logic ketersediaan mobil (sama seperti sebelumnya)
        $takenFromKetersediaan = \App\Models\Ketersediaan::whereDate('tanggal_keberangkatan', $date)
            ->pluck('mobil_id')
            ->toArray();

        $takenFromTransaksiConfirmed = \App\Models\Transaksi::whereHas('pemesanan', function ($q) use ($date) {
                $q->whereDate('tanggal_keberangkatan', $date);
            })
            ->whereIn('transaksi_status', ['paid', 'confirmed'])
            ->with('pemesanan')
            ->get()
            ->pluck('pemesanan.mobil_id')
            ->toArray();

        $fourHoursAgo = Carbon::now()->subHours(4);
        $takenFromHold = \App\Models\Transaksi::whereHas('pemesanan', function ($q) use ($date) {
                $q->whereDate('tanggal_keberangkatan', $date);
            })
            ->where('transaksi_status', 'pending')
            ->where('created_at', '>=', $fourHoursAgo)
            ->with('pemesanan')
            ->get()
            ->pluck('pemesanan.mobil_id')
            ->toArray();

        $takenMobilIds = array_unique(array_merge(
            $takenFromKetersediaan,
            $takenFromTransaksiConfirmed,
            $takenFromHold
        ));

        $available = \App\Models\Mobil::whereNotIn('mobil_id', $takenMobilIds)->get();

        return response()->json($available->pluck('mobil_id'));
    }
}
