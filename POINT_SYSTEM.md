# Sistem Poin Member - Bali Om Tours

## 📋 Overview
Sistem poin member yang otomatis menambahkan poin setiap kali transaksi berhasil dibayar dan hanya bisa digunakan untuk diskon booking. **Sekarang dengan pengaturan yang bisa diubah oleh admin!**

## 🎯 Cara Kerja
- **Trigger**: Transaksi status berubah menjadi `'paid'`
- **Observer**: `TransaksiObserver` menangani penambahan poin secara otomatis
- **Pengaturan Dinamis**: Admin bisa mengubah nilai poin melalui halaman "Pengaturan Poin"
- **Kondisi**: Hanya member (`is_member = true`) yang dapat poin
- **Penggunaan**: Hanya untuk diskon booking

## ⚙️ Pengaturan yang Bisa Diubah

### 1. Rupiah per Poin
- **Default**: Rp 500.000 = 5 poin
- **Admin bisa mengubah**: Berapa rupiah untuk mendapatkan poin

### 2. Poin per Transaksi  
- **Default**: 5 poin per transaksi
- **Admin bisa mengubah**: Berapa poin yang didapat per transaksi

### 3. Poin untuk Diskon
- **Default**: 10 poin untuk diskon
- **Admin bisa mengubah**: Berapa poin yang dibutuhkan untuk mendapatkan diskon

### 4. Diskon per Poin
- **Default**: Rp 10.000 diskon per 10 poin
- **Admin bisa mengubah**: Berapa rupiah diskon yang didapat

## 🔧 Implementasi

### TransaksiObserver.php
```php
// Ambil pengaturan poin dari database
$pointsPerTransaction = (int) PointSetting::getValue('points_per_transaction', 500000);
$pointsEarnedPerTransaction = (int) PointSetting::getValue('points_earned_per_transaction', 5);

$poinTambahan = floor($hargaAsli / $pointsPerTransaction) * $pointsEarnedPerTransaction;
```

### PemesananController.php
```php
// Ambil pengaturan poin dari database
$pointsForDiscount = (int) PointSetting::getValue('points_for_discount', 10);
$discountPerPoints = (int) PointSetting::getValue('discount_per_points', 10000);

// Hitung diskon berdasarkan pengaturan
$totalDiscount = ($pointsUsed / $pointsForDiscount) * $discountPerPoints;
```

## 📍 Lokasi File
- **Model**: `app/Models/PointSetting.php`
- **Controller**: `app/Http/Controllers/PointSettingsController.php`
- **View**: `resources/views/point-settings/index.blade.php`
- **Migration**: `database/migrations/2025_01_15_000000_create_point_settings_table.php`
- **Observer**: `app/Observers/TransaksiObserver.php`
- **Booking**: `app/Http/Controllers/PemesananController.php`
- **Component**: `resources/views/components/member-status.blade.php`

## 🎛️ Cara Menggunakan Pengaturan Poin

### Untuk Admin:
1. Login ke admin panel
2. Klik menu "Pengaturan Poin" di sidebar
3. Ubah nilai sesuai kebutuhan:
   - **Rupiah per Poin**: Setiap berapa rupiah untuk mendapatkan poin
   - **Poin per Transaksi**: Berapa poin yang didapat per transaksi
   - **Poin untuk Diskon**: Berapa poin yang dibutuhkan untuk diskon
   - **Diskon per Poin**: Berapa rupiah diskon per poin
4. Klik "Simpan Pengaturan"
5. Preview akan menampilkan contoh perhitungan

### Untuk Pelanggan:
- Status member ditampilkan di halaman pelanggan dengan badge
- Poin yang dimiliki ditampilkan di landing page dan detail paket
- Sistem otomatis menggunakan pengaturan terbaru untuk perhitungan

## ✅ Keuntungan
- **Fleksibel**: Admin bisa mengubah nilai poin tanpa coding
- **Real-time**: Perubahan langsung berlaku untuk transaksi baru
- **Preview**: Admin bisa lihat contoh perhitungan sebelum simpan
- **Konsisten**: Semua sistem menggunakan pengaturan yang sama
- **Backward Compatible**: Default values jika pengaturan belum diisi

## 📊 Contoh Perhitungan (Default)
- **Penambahan Poin**: Transaksi Rp 1.200.000 = 10 poin
- **Penggunaan Poin**: 10 poin = Rp 10.000 diskon
- **Transaksi dengan Diskon**: 
  - Harga asli: Rp 1.000.000
  - Diskon: Rp 100.000 (100 poin)
  - Bayar: Rp 900.000
  - Dapat poin: 10 poin (berdasarkan harga asli)

## 🔍 Monitoring
- Log di `storage/logs/laravel.log`
- Flash message untuk notifikasi user
- Database field `points` di tabel `pelanggans`
- Note di transaksi untuk tracking penggunaan poin
- Status member ditampilkan di tabel pelanggan

## 🚀 Fitur Baru
- **Pengaturan Dinamis**: Admin bisa ubah nilai poin
- **Status Member**: Tampilan badge member di tabel pelanggan
- **Preview Perhitungan**: Live preview saat mengubah pengaturan
- **Validasi Real-time**: Input validation dengan feedback visual 