<?php

namespace App\Http\Controllers;

use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\PaketWisata;
use App\Models\IncludeModel;
use App\Models\Exclude;
use App\Models\PointSetting;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class PaketWisataController extends Controller
{
    /**
     * Display a listing of paket wisata
     */
    public function index()
    {
        try {
            $pakets = PaketWisata::with(['include', 'exclude'])->get();
            return view('paket-wisata.index', compact('pakets'));
        } catch (\Exception $e) {
            Log::error('Error loading paket wisata index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    /**
     * Show the form for creating a new paket wisata
     */
    public function create()
    {
        return view('paket-wisata.create');
    }

    /**
     * Store a newly created paket wisata in storage
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data tidak valid. Silakan periksa kembali.');
        }

        $data = $request->all();

        DB::beginTransaction();

        try {
            // Generate unique slug
            $data['slug'] = $this->generateUniqueSlug($data['judul']);

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->uploadFile($request->file('foto'), 'paket-wisata');
            }

            // Handle gallery upload
            if ($request->hasFile('gallery')) {
                $data['gallery'] = $this->uploadMultipleFiles($request->file('gallery'), 'paket-wisata/gallery');
            }

            // Create paket wisata
            $paketWisata = PaketWisata::create($data);

            // Handle include/exclude
            $this->handleIncludeExclude($paketWisata, $request);

            DB::commit();

            return redirect()
                ->route('paket-wisata.index')
                ->with('success', 'Paket wisata berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Paket Wisata Store Error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up uploaded files if error
            $this->cleanupUploadedFiles($data);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified paket wisata
     */
    public function show(Request $request, string $slug)
    {
        try {
            $paket = PaketWisata::where('slug', $slug)
                ->with(['include', 'exclude'])
                ->firstOrFail();
            
            $mobil = Mobil::all();
            $activePointSettings = PointSetting::getActiveSettings();

            // Jika request AJAX, return view detail saja
            if ($request->ajax()) {
                return view('paket-wisata.detail-content', compact('paket', 'mobil', 'activePointSettings'));
            }

            // Jika bukan AJAX, return halaman detail lengkap
            return view('paket-wisata.detail', compact('paket', 'mobil', 'activePointSettings'));
            
        } catch (\Exception $e) {
            Log::error('Error loading paket wisata detail: ' . $e->getMessage());
            return redirect()->route('paket-wisata.index')->with('error', 'Paket wisata tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified paket wisata
     */
    public function edit(string $slug)
    {
        try {
            $paketwisata = PaketWisata::where('slug', $slug)->firstOrFail();
            $paketwisata->load(['include', 'exclude']);

            return view('paket-wisata.edit', compact('paketwisata'));
            
        } catch (\Exception $e) {
            Log::error('Error loading paket wisata edit form: ' . $e->getMessage());
            return redirect()->route('paket-wisata.index')->with('error', 'Paket wisata tidak ditemukan.');
        }
    }

    /**
     * Update the specified paket wisata in storage
     */
    public function update(Request $request, string $slug)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data tidak valid. Silakan periksa kembali.');
        }

        try {
            $paketwisata = PaketWisata::where('slug', $slug)->firstOrFail();
        } catch (\Exception $e) {
            return redirect()->route('paket-wisata.index')->with('error', 'Paket wisata tidak ditemukan.');
        }

        $data = $request->all();

        DB::beginTransaction();

        try {
            // Update slug jika judul berubah
            if ($paketwisata->judul !== $data['judul']) {
                $data['slug'] = $this->generateUniqueSlug($data['judul'], $paketwisata->paketwisata_id);
            }

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($paketwisata->foto) {
                    Storage::disk('public')->delete($paketwisata->foto);
                }
                $data['foto'] = $this->uploadFile($request->file('foto'), 'paket-wisata');
            }

            // Handle gallery update
            if ($request->hasFile('gallery')) {
                // Hapus gallery lama
                if ($paketwisata->gallery && is_array($paketwisata->gallery)) {
                    foreach ($paketwisata->gallery as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $data['gallery'] = $this->uploadMultipleFiles($request->file('gallery'), 'paket-wisata/gallery');
            }

            // Update paket wisata
            $paketwisata->update($data);

            // Update include/exclude
            $this->handleIncludeExclude($paketwisata, $request, true);

            DB::commit();

            return redirect()
                ->route('paket-wisata.index')
                ->with('success', 'Paket wisata berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Paket Wisata Update Error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'paket_slug' => $slug,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified paket wisata from storage
     */
    public function destroy(string $slug)
    {
        try {
            $paketwisata = PaketWisata::where('slug', $slug)->firstOrFail();
        } catch (\Exception $e) {
            return redirect()->route('paket-wisata.index')->with('error', 'Paket wisata tidak ditemukan.');
        }

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

            if ($paketwisata->gallery && is_array($paketwisata->gallery)) {
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

            Log::error('Paket Wisata Delete Error: ' . $e->getMessage(), [
                'paket_slug' => $slug,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Display paket wisata list for landing page
     */
    public function list()
    {
        try {
            $paket = PaketWisata::with(['include', 'exclude'])
                ->orderBy('created_at', 'desc')
                ->get();
            $mobil = Mobil::all();
            $activePointSettings = PointSetting::getActiveSettings();

            return view('paket-wisata.landing-page', compact('paket', 'mobil', 'activePointSettings'));
        } catch (\Exception $e) {
            Log::error('Error loading paket wisata list: ' . $e->getMessage());
            return view('paket-wisata.landing-page', ['paket' => collect(), 'mobil' => collect(), 'activePointSettings' => null]);
        }
    }

    /**
     * Check availability of mobil for specific date
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $date = $request->query('date');
            
            if (!$date) {
                return response()->json(['error' => 'Date parameter is required'], 400);
            }

            $currentTime = Carbon::now();
            $requestDate = Carbon::parse($date);

            // Cek pembatasan waktu booking untuk besok
            $tomorrow = Carbon::tomorrow();
            if ($requestDate->isSameDay($tomorrow) && $currentTime->hour >= 17) {
                return response()->json([]);
            }

            // Get taken mobil IDs from various sources
            $takenMobilIds = $this->getTakenMobilIds($date);

            // Get available mobil
            $available = Mobil::whereNotIn('mobil_id', $takenMobilIds)->get();

            return response()->json($available->pluck('mobil_id'));
            
        } catch (\Exception $e) {
            Log::error('Error checking mobil availability: ' . $e->getMessage(), [
                'date' => $request->query('date'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Terjadi kesalahan saat mengecek ketersediaan'], 500);
        }
    }

    /**
     * Generate unique slug for paket wisata
     */
    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        $query = PaketWisata::where('slug', $slug);
        if ($excludeId) {
            $query->where('paketwisata_id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
            
            $query = PaketWisata::where('slug', $slug);
            if ($excludeId) {
                $query->where('paketwisata_id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Upload single file
     */
    private function uploadFile($file, string $directory): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Upload multiple files
     */
    private function uploadMultipleFiles(array $files, string $directory): array
    {
        $uploadedPaths = [];
        foreach ($files as $file) {
            $uploadedPaths[] = $this->uploadFile($file, $directory);
        }
        return $uploadedPaths;
    }

    /**
     * Handle include/exclude logic
     */
    private function handleIncludeExclude(PaketWisata $paketWisata, Request $request, bool $isUpdate = false): void
    {
        $includeFields = ['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk'];

        $includeData = [];
        $excludeData = [];

        foreach ($includeFields as $field) {
            if ($request->has("include.$field") && $request->input("include.$field") == '1') {
                $includeData[$field] = true;
                $excludeData[$field] = false;
            } else {
                $includeData[$field] = false;
                $excludeData[$field] = true;
            }
        }

        if ($isUpdate) {
            // Update existing records
            if ($paketWisata->include) {
                $paketWisata->include->update($includeData);
            } else {
                $includeData['paketwisata_id'] = $paketWisata->paketwisata_id;
                $includeData['status_ketersediaan'] = 1;
                IncludeModel::create($includeData);
            }

            if ($paketWisata->exclude) {
                $paketWisata->exclude->update($excludeData);
            } else {
                $excludeData['paketwisata_id'] = $paketWisata->paketwisata_id;
                $excludeData['status_ketersediaan'] = 1;
                Exclude::create($excludeData);
            }
        } else {
            // Create new records
            $includeData['paketwisata_id'] = $paketWisata->paketwisata_id;
            $includeData['status_ketersediaan'] = 1;
            IncludeModel::create($includeData);

            $excludeData['paketwisata_id'] = $paketWisata->paketwisata_id;
            $excludeData['status_ketersediaan'] = 1;
            Exclude::create($excludeData);
        }
    }

    /**
     * Get taken mobil IDs for specific date
     */
    private function getTakenMobilIds(string $date): array
    {
        // From Ketersediaan table
        $takenFromKetersediaan = Ketersediaan::whereDate('tanggal_keberangkatan', $date)
            ->pluck('mobil_id')
            ->toArray();

        // From confirmed transactions
        $takenFromTransaksiConfirmed = Transaksi::whereHas('pemesanan', function ($q) use ($date) {
                $q->whereDate('tanggal_keberangkatan', $date);
            })
            ->whereIn('transaksi_status', ['paid', 'confirmed'])
            ->with('pemesanan')
            ->get()
            ->pluck('pemesanan.mobil_id')
            ->filter()
            ->toArray();

        // From pending transactions (hold for 4 hours)
        $fourHoursAgo = Carbon::now()->subHours(4);
        $takenFromHold = Transaksi::whereHas('pemesanan', function ($q) use ($date) {
                $q->whereDate('tanggal_keberangkatan', $date);
            })
            ->where('transaksi_status', 'pending')
            ->where('created_at', '>=', $fourHoursAgo)
            ->with('pemesanan')
            ->get()
            ->pluck('pemesanan.mobil_id')
            ->filter()
            ->toArray();

        return array_unique(array_merge(
            $takenFromKetersediaan,
            $takenFromTransaksiConfirmed,
            $takenFromHold
        ));
    }

    /**
     * Clean up uploaded files when error occurs
     */
    private function cleanupUploadedFiles(array $data): void
    {
        if (isset($data['foto']) && Storage::disk('public')->exists($data['foto'])) {
            Storage::disk('public')->delete($data['foto']);
        }

        if (isset($data['gallery']) && is_array($data['gallery'])) {
            foreach ($data['gallery'] as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
    }
}