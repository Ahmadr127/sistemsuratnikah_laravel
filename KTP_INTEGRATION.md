# Integrasi API KTP dengan Sistem Surat Nikah

## Overview
Sistem surat nikah telah diintegrasikan dengan API KTP untuk validasi data calon pengantin secara real-time. Integrasi ini memungkinkan sistem untuk:

1. **Validasi NIK** - Memverifikasi NIK calon pengantin melalui API KTP
2. **Validasi Status Perkawinan** - Memastikan calon pengantin belum menikah
3. **Validasi Status KTP** - Memastikan KTP sudah selesai dan valid
4. **Pengambilan Data Lengkap** - Mengambil semua data pribadi dari API KTP

## API Endpoints

### 1. Get All KTP Data
```
GET https://ktp.chasouluix.biz.id/api/ktp/all
```

**Response:**
```json
{
    "success": true,
    "message": "Data KTP berhasil diambil.",
    "total": 5,
    "data": [...]
}
```

### 2. Get KTP by NIK
```
GET https://ktp.chasouluix.biz.id/api/ktp/nik/{nik}
```

**Response:**
```json
{
    "success": true,
    "message": "Data KTP berhasil diambil.",
    "data": {
        "id": "1",
        "nik": "3201012345670001",
        "nama_lengkap": "Ahmad Wijaya",
        "tempat_lahir": "Jakarta",
        "tanggal_lahir": "1990-01-15",
        "jenis_kelamin": "L",
        "golongan_darah": "A",
        "agama": "Islam",
        "status_perkawinan": "Belum Kawin",
        "pekerjaan": "Pegawai Swasta",
        "kewarganegaraan": "WNI",
        "alamat": "Jl. Merdeka No. 123, RT 001, RW 005",
        "provinsi": "DKI Jakarta",
        "kabupaten": "Jakarta Pusat",
        "kecamatan": "Gambir",
        "kelurahan": "Gambir",
        "rt": "001",
        "rw": "005",
        "kode_pos": "10110",
        "no_telepon": "081234567890",
        "status": "selesai",
        "tanggal_pengajuan": "2025-08-22 01:49:44",
        "tanggal_selesai": "2025-09-16 01:49:44",
        "user_name": "Ahmad Wijaya",
        "user_email": "ahmad.wijaya@email.com"
    }
}
```

## Komponen Sistem

### 1. KtpApiService (`app/Services/KtpApiService.php`)
Service class yang menangani komunikasi dengan API KTP:

- `getAllKtp()` - Mengambil semua data KTP
- `getKtpByNik($nik)` - Mengambil data KTP berdasarkan NIK
- `validateKtpForMarriage($ktpData)` - Validasi data KTP untuk pernikahan
- `formatKtpForMarriage($ktpData)` - Format data KTP untuk form pernikahan

### 2. KtpData Model (`app/Models/KtpData.php`)
Model untuk menyimpan data KTP dengan method helper:

- `isReadyForMarriage()` - Cek apakah KTP siap untuk pernikahan
- `getFormattedNameAttribute()` - Format nama dengan prefix gender
- `getFullAddressAttribute()` - Alamat lengkap
- `getAgeAttribute()` - Usia dari tanggal lahir
- `isEligibleForMarriage()` - Cek kelayakan menikah (min 19 tahun)

### 3. AdminController Updates
Controller telah diperbarui untuk mengintegrasikan API KTP:

- `searchNik()` - Menggunakan API KTP untuk validasi NIK
- `ktpData()` - Menampilkan semua data KTP
- `searchKtp()` - Pencarian KTP berdasarkan NIK

## Validasi Data

### Kriteria Validasi untuk Pernikahan:
1. **Status KTP = "selesai"** - KTP harus sudah selesai
2. **Status Perkawinan = "Belum Kawin"** - Belum menikah
3. **Usia >= 19 tahun** - Memenuhi syarat usia menikah
4. **NIK valid** - Format NIK 16 digit angka

### Error Handling:
- API timeout (30 detik)
- Network errors
- Invalid NIK format
- Data tidak ditemukan
- Status tidak memenuhi syarat

## Tampilan Baru

### 1. Data KTP (`/admin/ktp-data`)
- Tampilan semua data KTP dari API
- Statistik data KTP
- Pencarian berdasarkan NIK
- Aksi untuk membuat pernikahan

### 2. Detail KTP (`/admin/ktp-detail`)
- Detail lengkap data KTP
- Informasi pribadi, alamat, dan status
- Tombol aksi untuk pernikahan

### 3. Form Pernikahan yang Diperbarui
- Data calon pengantin yang lebih lengkap
- Informasi dari API KTP
- Validasi real-time

## Routes Baru

```php
// KTP Data Management
Route::get('/ktp-data', [AdminController::class, 'ktpData'])->name('ktp-data');
Route::post('/ktp-search', [AdminController::class, 'searchKtp'])->name('ktp-search');
```

## Konfigurasi

### Environment Variables (Opsional)
```env
KTP_API_URL=https://ktp.chasouluix.biz.id/api/ktp
KTP_API_TIMEOUT=30
```

### Service Provider Registration
Service `KtpApiService` akan di-inject secara otomatis ke `AdminController` melalui dependency injection.

## Penggunaan

### 1. Akses Data KTP
1. Login sebagai admin
2. Klik "Data KTP" di dashboard
3. Lihat semua data KTP atau cari berdasarkan NIK

### 2. Membuat Pernikahan
1. Klik "Buat Buku Nikah"
2. Masukkan NIK calon pengantin
3. Sistem akan validasi melalui API KTP
4. Lengkapi informasi pernikahan
5. Simpan data pernikahan

### 3. Validasi Otomatis
- NIK akan divalidasi format (16 digit)
- Data akan diambil dari API KTP
- Status perkawinan akan dicek
- Status KTP akan divalidasi

## Error Messages

### NIK Validation:
- "NIK calon pengantin pria/wanita wajib diisi"
- "NIK calon pengantin pria/wanita harus 16 digit"
- "NIK calon pengantin pria/wanita harus berupa angka"

### API Errors:
- "Data KTP tidak ditemukan"
- "Status KTP belum selesai"
- "Orang tersebut sudah menikah"
- "Terjadi kesalahan saat mengakses API KTP"

## Testing

### Manual Testing:
1. Test dengan NIK valid yang ada di API
2. Test dengan NIK yang tidak ada
3. Test dengan NIK yang sudah menikah
4. Test dengan NIK yang status KTP belum selesai

### API Testing:
```bash
# Test API endpoint
curl -X GET "https://ktp.chasouluix.biz.id/api/ktp/all"
curl -X GET "https://ktp.chasouluix.biz.id/api/ktp/nik/3201012345670001"
```

## Troubleshooting

### Common Issues:
1. **API Timeout** - Periksa koneksi internet
2. **Data tidak muncul** - Periksa response API
3. **Validasi gagal** - Periksa format NIK dan status data
4. **Error 500** - Periksa log Laravel untuk detail error

### Debug Mode:
Aktifkan debug mode di `.env` untuk melihat detail error:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## Security Considerations

1. **API Key** - Jika API memerlukan authentication
2. **Rate Limiting** - Implementasi rate limiting jika diperlukan
3. **Data Privacy** - Data KTP sensitif, pastikan keamanan
4. **HTTPS** - Pastikan komunikasi dengan API menggunakan HTTPS

## Future Enhancements

1. **Caching** - Implementasi cache untuk data KTP
2. **Batch Processing** - Import data KTP dalam jumlah besar
3. **Notifications** - Notifikasi untuk status KTP
4. **Reports** - Laporan data KTP dan pernikahan
5. **API Monitoring** - Monitoring kesehatan API KTP
