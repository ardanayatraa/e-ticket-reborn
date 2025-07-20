# Sistem Poin Member - Bali Om Tours

## 📋 Overview
Sistem poin member yang otomatis menambahkan poin setiap kali transaksi berhasil dibayar dan hanya bisa digunakan untuk diskon booking. **Sekarang dengan pengaturan season-based yang bisa diatur oleh admin!**

## 🎯 Cara Kerja
- **Trigger**: Transaksi status berubah menjadi `'paid'`
- **Observer**: `TransaksiObserver` menangani penambahan poin secara otomatis
- **Pengaturan Dinamis**: Admin bisa mengatur multiple season dengan nilai poin berbeda
- **Kondisi**: Hanya member (`is_member = true`) yang dapat poin
- **Penggunaan**: Hanya untuk diskon booking

## ⚙️ Struktur Database Baru

### Tabel: point_settings
| Field | Tipe Data | Keterangan |
|-------|-----------|------------|
| point_id | INT | Primary Key |
| nama_season_point | VARCHAR | Nama season, contoh: Low / High |
| minimum_transaksi | INT | Nilai minimum transaksi |
| jumlah_point_diperoleh | INT | Berapa point yang didapat |
| harga_satuan_point | INT | Nilai konversi per point |
| is_active | BOOLEAN | Status aktif: 1 = aktif, 0 = nonaktif |
| created_at | TIMESTAMP | Waktu buat |
| updated_at | TIMESTAMP | Waktu update |

## 🎛️ Pengaturan Season-Based

### Default Settings:
1. **Low Season**
   - Minimum transaksi: Rp 500.000
   - Point diperoleh: 5 point
   - Harga satuan point: Rp 10.000
   - Status: Aktif

2. **High Season**
   - Minimum transaksi: Rp 1.000.000
   - Point diperoleh: 10 point
   - Harga satuan point: Rp 15.000
   - Status: Aktif

## 🔧 Implementasi

### TransaksiObserver.php
```php
// Ambil pengaturan poin dari database berdasarkan jumlah transaksi
$poinTambahan = PointSetting::calculateEarnedPoints($hargaAsli);
```

### PemesananController.php
```php
// Ambil pengaturan poin aktif dari database
$activeSettings = PointSetting::getActiveSettings();

if ($activeSettings->isEmpty()) {
    throw new \Exception("Tidak ada pengaturan poin yang aktif");
}

$setting = $activeSettings->first();

if ($pointsUsed % $setting->jumlah_point_diperoleh !== 0) {
    throw new \Exception("Poin harus dalam kelipatan {$setting->jumlah_point_diperoleh}");
}

// Hitung diskon berdasarkan pengaturan
$totalDiscount = PointSetting::calculateDiscount($pointsUsed);
```

### PaketWisataController.php
```php
// Ambil pengaturan poin aktif untuk keuntungan member
$activePointSettings = PointSetting::getActiveSettings();

return view('paket-wisata.landing-page', compact('paket', 'mobil', 'activePointSettings'));
```

## 📍 Lokasi File
- **Model**: `app/Models/PointSetting.php`
- **Controller**: `app/Http/Controllers/PointSettingsController.php`
- **Views**: 
  - `resources/views/point-settings/index.blade.php`
  - `resources/views/point-settings/create.blade.php`
  - `resources/views/point-settings/edit.blade.php`
- **Migration**: `database/migrations/2025_07_20_221326_update_point_settings_table_structure.php`
- **Observer**: `app/Observers/TransaksiObserver.php`
- **Booking**: `app/Http/Controllers/PemesananController.php`
- **Landing Page**: `resources/views/paket-wisata/landing-page.blade.php`
- **Detail Page**: `resources/views/paket-wisata/detail.blade.php`
- **Component**: `resources/views/components/member-status.blade.php`

## 🎛️ Cara Menggunakan Pengaturan Poin

### Untuk Admin:
1. Login ke admin panel
2. Klik menu "Pengaturan Poin" di sidebar
3. **Lihat Daftar**: Tabel menampilkan semua pengaturan season
4. **Tambah Baru**: Klik "Tambah Pengaturan" untuk membuat season baru
5. **Edit**: Klik icon edit untuk mengubah pengaturan
6. **Aktif/Nonaktif**: Toggle status aktif dengan icon play/pause
7. **Hapus**: Klik icon trash untuk menghapus pengaturan
8. **Preview**: Masukkan jumlah transaksi untuk melihat perhitungan

### Untuk Pelanggan:
- Status member ditampilkan di halaman pelanggan dengan badge
- Poin yang dimiliki ditampilkan di landing page dan detail paket
- Sistem otomatis menggunakan pengaturan season yang sesuai

## 🌐 Frontend Integration

### Landing Page Updates
- **Keuntungan Member**: Menampilkan pengaturan point aktif
- **Riwayat Transaksi**: Menghitung point earned menggunakan `PointSetting::calculateEarnedPoints()`
- **Point Redemption**: Menggunakan pengaturan aktif untuk validasi dan perhitungan

### Detail Page Updates
- **Keuntungan Member**: Menampilkan pengaturan point aktif
- **Point Redemption**: Form input dengan validasi berdasarkan pengaturan aktif
- **JavaScript**: Perhitungan real-time menggunakan pengaturan aktif

### Dynamic Point Calculation
```php
// Di view
@if($activePointSettings->isNotEmpty())
    @php
        $firstSetting = $activePointSettings->first();
    @endphp
    <li>Setiap Rp {{ number_format($firstSetting->minimum_transaksi, 0, ',', '.') }}
        = {{ $firstSetting->jumlah_point_diperoleh }} poin</li>
@endif
```

## ✅ Keuntungan Sistem Baru
- **Season-Based**: Bisa atur pengaturan berbeda untuk low/high season
- **Multiple Settings**: Bisa buat banyak pengaturan dengan nilai berbeda
- **Flexible**: Admin bisa aktif/nonaktif pengaturan sesuai kebutuhan
- **CRUD Operations**: Full create, read, update, delete untuk pengaturan
- **Real-time Preview**: Lihat perhitungan sebelum simpan
- **Frontend Integration**: Landing page dan detail page otomatis menggunakan pengaturan aktif
- **Backward Compatible**: Sistem tetap berjalan dengan pengaturan default

## 📊 Contoh Perhitungan (Low Season)
- **Penambahan Poin**: Transaksi Rp 1.200.000 = 10 poin
- **Penggunaan Poin**: 5 poin = Rp 10.000 diskon
- **Transaksi dengan Diskon**: 
  - Harga asli: Rp 1.000.000
  - Diskon: Rp 100.000 (50 poin)
  - Bayar: Rp 900.000
  - Dapat poin: 10 poin (berdasarkan harga asli)

## 📊 Contoh Perhitungan (High Season)
- **Penambahan Poin**: Transaksi Rp 1.200.000 = 10 poin
- **Penggunaan Poin**: 10 poin = Rp 15.000 diskon
- **Transaksi dengan Diskon**: 
  - Harga asli: Rp 1.000.000
  - Diskon: Rp 150.000 (100 poin)
  - Bayar: Rp 850.000
  - Dapat poin: 10 poin (berdasarkan harga asli)

## 🔍 Monitoring
- Log di `storage/logs/laravel.log`
- Flash message untuk notifikasi user
- Database field `points` di tabel `pelanggans`
- Note di transaksi untuk tracking penggunaan poin
- Status aktif/nonaktif di tabel point_settings

## 🚀 Fitur Baru
1. **Season Management**: Buat dan kelola multiple season
2. **Dynamic Calculation**: Perhitungan otomatis berdasarkan season
3. **Active/Inactive Toggle**: Aktifkan/nonaktifkan pengaturan
4. **Real-time Preview**: Lihat hasil perhitungan secara real-time
5. **CRUD Interface**: Interface lengkap untuk mengelola pengaturan
6. **Validation**: Validasi input yang ketat
7. **Error Handling**: Penanganan error yang baik
8. **Frontend Integration**: Landing page dan detail page terintegrasi dengan sistem baru 