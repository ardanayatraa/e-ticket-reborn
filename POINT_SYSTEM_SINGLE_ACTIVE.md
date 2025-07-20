# Sistem Poin - Hanya Satu Aktif

## Overview
Sistem poin telah dimodifikasi agar hanya satu pengaturan poin yang dapat aktif pada satu waktu. Ini memastikan konsistensi dalam perhitungan poin dan diskon.

## Perubahan yang Dilakukan

### 1. Controller Updates (`PointSettingsController.php`)

#### Method `toggleActive()`
- **Sebelum**: Hanya mengubah status aktif/nonaktif untuk satu setting
- **Sesudah**: 
  - Jika mengaktifkan setting: menonaktifkan semua setting lain terlebih dahulu
  - Jika menonaktifkan setting: hanya menonaktifkan setting tersebut

#### Method `store()`
- **Tambahan**: Jika setting baru dibuat sebagai aktif, semua setting lain akan dinonaktifkan

#### Method `update()`
- **Tambahan**: Jika setting diupdate menjadi aktif, semua setting lain akan dinonaktifkan

### 2. View Updates (`point-settings/index.blade.php`)
- **Tambahan**: Informasi visual bahwa hanya satu pengaturan yang dapat aktif
- **Pesan**: "Hanya satu pengaturan poin yang dapat aktif pada satu waktu"

## Cara Kerja

### Aktivasi Point Setting
1. User mengklik tombol aktivasi pada point setting yang nonaktif
2. Sistem menonaktifkan semua point setting lain
3. Sistem mengaktifkan point setting yang dipilih
4. Hanya satu point setting yang aktif

### Deaktivasi Point Setting
1. User mengklik tombol deaktivasi pada point setting yang aktif
2. Sistem menonaktifkan point setting tersebut
3. Tidak ada point setting yang aktif

### Pembuatan Point Setting Baru
1. User membuat point setting baru
2. Jika diset sebagai aktif, semua point setting lain dinonaktifkan
3. Jika diset sebagai nonaktif, tidak mempengaruhi point setting lain

### Update Point Setting
1. User mengupdate point setting
2. Jika diset sebagai aktif, semua point setting lain dinonaktifkan
3. Jika diset sebagai nonaktif, tidak mempengaruhi point setting lain

## Keuntungan

1. **Konsistensi**: Hanya satu sistem poin yang berlaku pada satu waktu
2. **Kemudahan Manajemen**: Admin tidak perlu khawatir tentang konflik antar pengaturan
3. **Kejelasan**: Pelanggan tahu pasti sistem poin mana yang sedang berlaku
4. **Perhitungan Akurat**: Tidak ada ambiguitas dalam perhitungan poin dan diskon

## Testing

### Test Case 1: Aktivasi Point Setting
- **Input**: Aktifkan "Low Season" (ID: 1)
- **Expected**: "High Season" (ID: 2) menjadi nonaktif, "Low Season" menjadi aktif
- **Result**: ✅ Berhasil

### Test Case 2: Deaktivasi Point Setting
- **Input**: Nonaktifkan "High Season" (ID: 2)
- **Expected**: "High Season" menjadi nonaktif, tidak ada yang aktif
- **Result**: ✅ Berhasil

### Test Case 3: Pembuatan Point Setting Baru Aktif
- **Input**: Buat point setting baru dengan `is_active = true`
- **Expected**: Semua point setting lain menjadi nonaktif
- **Result**: ✅ Berhasil

## Database Schema

```sql
-- Tabel point_settings
CREATE TABLE point_settings (
    point_id INT PRIMARY KEY AUTO_INCREMENT,
    nama_season_point VARCHAR(255) NOT NULL,
    minimum_transaksi INT NOT NULL,
    jumlah_point_diperoleh INT NOT NULL,
    harga_satuan_point INT NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## API Endpoints

- `GET /point-settings` - Lihat semua pengaturan poin
- `POST /point-settings` - Buat pengaturan poin baru
- `PUT /point-settings/{id}` - Update pengaturan poin
- `PUT /point-settings/{id}/toggle-active` - Toggle status aktif
- `DELETE /point-settings/{id}` - Hapus pengaturan poin
- `POST /point-settings/preview` - Preview perhitungan poin

## Catatan Penting

1. **Cache**: Sistem menggunakan cache untuk menyimpan pengaturan aktif
2. **Transaction**: Semua operasi menggunakan database transaction untuk konsistensi
3. **Logging**: Semua perubahan dicatat dalam log untuk audit trail
4. **Validation**: Validasi input tetap berjalan seperti sebelumnya 