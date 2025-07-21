# Merge Tabel Pemesanan ke Ketersediaan

## Overview
Tabel `pemesanans` telah berhasil dimerge ke dalam tabel `ketersediaans` untuk menghilangkan redundansi dan menyederhanakan struktur database.

## Perubahan yang Dilakukan

### 1. **Database Migration** (`2025_07_20_232540_merge_pemesanans_to_ketersediaans.php`)

#### **Tabel Ketersediaans (Target)**
**Sebelum:**
```sql
CREATE TABLE ketersediaans (
    terpesan_id BIGINT PRIMARY KEY,
    pemesanan_id BIGINT,
    mobil_id BIGINT,
    tanggal_keberangkatan DATE,
    status_ketersediaan VARCHAR(20),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Sesudah:**
```sql
CREATE TABLE ketersediaans (
    terpesan_id BIGINT PRIMARY KEY,
    pelanggan_id BIGINT,
    paketwisata_id BIGINT,
    jam_mulai TIME,
    mobil_id BIGINT,
    tanggal_keberangkatan DATE,
    status_ketersediaan VARCHAR(20),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggans(pelanggan_id),
    FOREIGN KEY (paketwisata_id) REFERENCES paket_wisatas(paketwisata_id),
    FOREIGN KEY (mobil_id) REFERENCES mobils(mobil_id)
);
```

#### **Tabel Transaksis**
**Sebelum:**
```sql
pemesanan_id BIGINT
```

**Sesudah:**
```sql
terpesan_id BIGINT
```

#### **Tabel Includes & Excludes**
**Tidak berubah** - Tetap menggunakan `paketwisata_id` sebagai foreign key utama
```sql
-- Includes dan excludes tetap terhubung ke paket wisata, bukan ke pemesanan
CREATE TABLE includes (
    include_id BIGINT PRIMARY KEY,
    paketwisata_id BIGINT NOT NULL,
    -- ... other fields
    FOREIGN KEY (paketwisata_id) REFERENCES paket_wisatas(paketwisata_id)
);
```

### 2. **Model Updates**

#### **Ketersediaan Model** (`app/Models/Ketersediaan.php`)
- **Primary Key**: `terpesan_id`
- **Fillable Fields**: 
  - `pelanggan_id`
  - `paketwisata_id`
  - `mobil_id`
  - `jam_mulai`
  - `tanggal_keberangkatan`
  - `status_ketersediaan`
- **Relationships**:
  - `belongsTo(Pelanggan)`
  - `belongsTo(PaketWisata)`
  - `belongsTo(Mobil)`
  - `hasOne(Transaksi)`
- **Scopes**: `paid()`, `pending()`
- **Accessors**: `status_pembayaran`, `total_harga`

#### **Transaksi Model** (`app/Models/Transaksi.php`)
- **Updated Fillable**: `terpesan_id` instead of `pemesanan_id`
- **Updated Relationships**: `belongsTo(Ketersediaan)` instead of `belongsTo(Pemesanan)`

#### **IncludeModel & Exclude Models**
- **Tidak berubah** - Tetap menggunakan `paketwisata_id` sebagai foreign key utama
- **Relationships**: `belongsTo(PaketWisata)` (tidak berubah)

### 3. **Controller Updates**

#### **PemesananController** (`app/Http/Controllers/PemesananController.php`)
- **Model**: Changed from `Pemesanan` to `Ketersediaan`
- **Primary Key**: Changed from `pemesanan_id` to `terpesan_id`
- **Store Method**: Creates `Ketersediaan` with `status_ketersediaan = 'pending'`
- **All References**: Updated to use `terpesan_id`

#### **KetersediaanController** (`app/Http/Controllers/KetersediaanController.php`)
- **Removed**: References to `Pemesanan` model
- **Added**: References to `Pelanggan` and `PaketWisata` models
- **Updated**: Validation rules to include all new fields

#### **TransaksiController** (`app/Http/Controllers/TransaksiController.php`)
- **Model**: Changed from `Pemesanan` to `Ketersediaan`
- **Relationships**: Updated to use `ketersediaan` instead of `pemesanan`
- **Validation**: Updated to use `terpesan_id`

### 4. **Observer Updates**

#### **TransaksiObserver** (`app/Observers/TransaksiObserver.php`)
- **Updated**: Logic to update `status_ketersediaan` to 'confirmed' when transaction is paid
- **Removed**: Logic to create new ketersediaan (now handled in PemesananController)

### 5. **Livewire Table Updates**

#### **PemesananTable** (`app/Livewire/Table/PemesananTable.php`)
- **Model**: Changed from `Pemesanan` to `Ketersediaan`
- **Primary Key**: Changed from `pemesanan_id` to `terpesan_id`
- **Columns**: Added `status_ketersediaan` column
- **Actions**: Updated to use `terpesan_id`

#### **TransaksiTable** (`app/Livewire/Table/TransaksiTable.php`)
- **Relationships**: Updated to use `ketersediaan.mobil` instead of `pemesanan.mobil`
- **Columns**: Updated to reference `terpesan_id`

## Keuntungan Setelah Merge

### 1. **Eliminasi Redundansi**
- ❌ **Sebelum**: `mobil_id` dan `tanggal_keberangkatan` duplikasi di 2 tabel
- ✅ **Sesudah**: Data tersimpan di 1 tempat saja

### 2. **Simplified Schema**
- ❌ **Sebelum**: 2 tabel terpisah dengan relasi 1:1
- ✅ **Sesudah**: 1 tabel dengan semua data yang diperlukan

### 3. **Better Performance**
- ❌ **Sebelum**: Perlu JOIN untuk data ketersediaan
- ✅ **Sesudah**: Data langsung tersedia di tabel utama

### 4. **Data Consistency**
- ❌ **Sebelum**: Risk of data inconsistency antara 2 tabel
- ✅ **Sesudah**: Single source of truth

### 5. **Easier Maintenance**
- ❌ **Sebelum**: 2 controller, 2 model, 2 set of views
- ✅ **Sesudah**: 1 controller, 1 model, unified approach

## Struktur Database Final

```sql
-- Tabel utama untuk booking
CREATE TABLE ketersediaans (
    terpesan_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    pelanggan_id BIGINT NOT NULL,
    paketwisata_id BIGINT NOT NULL,
    mobil_id BIGINT NOT NULL,
    jam_mulai TIME NOT NULL,
    tanggal_keberangkatan DATE NOT NULL,
    status_ketersediaan VARCHAR(20) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggans(pelanggan_id),
    FOREIGN KEY (paketwisata_id) REFERENCES paket_wisatas(paketwisata_id),
    FOREIGN KEY (mobil_id) REFERENCES mobils(mobil_id)
);

-- Tabel transaksi
CREATE TABLE transaksis (
    transaksi_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    paketwisata_id BIGINT NOT NULL,
    pelanggan_id BIGINT NOT NULL,
    terpesan_id BIGINT NOT NULL,
    -- ... other fields
    FOREIGN KEY (terpesan_id) REFERENCES ketersediaans(terpesan_id)
);

-- Tabel includes tetap terhubung ke paket wisata
CREATE TABLE includes (
    include_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    paketwisata_id BIGINT NOT NULL,
    -- ... other fields
    FOREIGN KEY (paketwisata_id) REFERENCES paket_wisatas(paketwisata_id)
);

-- Tabel excludes tetap terhubung ke paket wisata
CREATE TABLE excludes (
    exclude_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    paketwisata_id BIGINT NOT NULL,
    -- ... other fields
    FOREIGN KEY (paketwisata_id) REFERENCES paket_wisatas(paketwisata_id)
);
```

## Testing Checklist

### ✅ **Database Migration**
- [x] Migration berhasil dijalankan
- [x] Tabel `pemesanans` dihapus
- [x] Kolom baru ditambahkan ke `ketersediaans`
- [x] Foreign key constraints diperbarui

### ✅ **Model Relationships**
- [x] Ketersediaan model berfungsi
- [x] Transaksi model berfungsi
- [x] IncludeModel & Exclude models berfungsi

### ✅ **Controllers**
- [x] PemesananController menggunakan Ketersediaan
- [x] KetersediaanController diperbarui
- [x] TransaksiController diperbarui

### ✅ **Routes**
- [x] Semua route pemesanan masih berfungsi
- [x] Route menggunakan model yang benar

### ✅ **Livewire Tables**
- [x] PemesananTable diperbarui
- [x] TransaksiTable diperbarui

## Catatan Penting

1. **Backward Compatibility**: Semua route dan URL tetap sama untuk user
2. **Data Migration**: Data dari `pemesanans` berhasil dimigrasikan ke `ketersediaans`
3. **Foreign Keys**: Semua foreign key constraints diperbarui dengan benar
4. **Performance**: Query menjadi lebih efisien tanpa JOIN yang tidak perlu

## Next Steps

1. **Testing**: Test semua fitur booking dan transaksi
2. **Views**: Update views jika ada yang masih menggunakan field lama
3. **Documentation**: Update dokumentasi API jika ada
4. **Monitoring**: Monitor performance setelah perubahan

## Rollback Plan

Jika diperlukan rollback, migration `down()` method akan:
1. Recreate tabel `pemesanans`
2. Restore semua foreign key constraints
3. Remove kolom yang ditambahkan dari `ketersediaans`
4. Restore data ke struktur lama 