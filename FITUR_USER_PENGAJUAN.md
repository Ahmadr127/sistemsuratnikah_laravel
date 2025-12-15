# 📋 Fitur User - Pengajuan & Status Pernikahan

## ✅ Status Implementasi Fitur

### **1. Form Pengajuan Pernikahan** ✅ SUDAH ADA

**File**: [resources/views/marriage/request-form.blade.php](resources/views/marriage/request-form.blade.php)

#### **Proses Pengajuan (2 Tahap)**

**Tahap 1: Verifikasi NIK via API KTP**

```
User input:
- NIK Calon Pengantin Pria (16 digit)
- NIK Calon Pengantin Wanita (16 digit)

Route: POST /marriage/search-nik
Controller: MarriageController::searchNik()

Proses:
1. Validasi format NIK (16 digit numerik)
2. Call KTP API untuk calon pengantin pria
3. Call KTP API untuk calon pengantin wanita
4. Validasi marriage eligibility:
   - Umur >= 19 tahun
   - Status perkawinan ≠ "Kawin" (belum menikah)
   - Gender berbeda (pria ≠ wanita)
5. Format data dari API
6. Simpan ke session: marriage_prefill
7. Reload form dengan data prefilled
```

**Tahap 2: Lengkapi Detail Pernikahan**

```
Form fields:

Data Calon Pengantin Pria:
- Nama Lengkap
- NIK
- Tempat Lahir
- Tanggal Lahir (dari API)
- Alamat

Data Calon Pengantin Wanita:
- Nama Lengkap
- NIK
- Tempat Lahir
- Tanggal Lahir (dari API)
- Alamat

Detail Pernikahan:
- Tanggal Pernikahan (harus >= hari ini)
- Tempat Pernikahan
- Nama Saksi 1
- Nama Saksi 2

Route: POST /marriage/request
Controller: MarriageController::submitRequest()

Proses:
1. Validasi semua field
2. Marriage::create() dengan status='active'
3. Set created_by = auth()->user()->id
4. Clear session prefill data
5. Redirect ke /marriage/status dengan success message
```

#### **Form Input Fields**

```
┌─────────────────────────────────────────┐
│ Formulir Pengajuan Buku Nikah           │
├─────────────────────────────────────────┤
│ VERIFIKASI NIK                          │
│ [NIK Pria: 16 digit    ] [Cari]         │
│ [NIK Wanita: 16 digit  ]                │
├─────────────────────────────────────────┤
│ DATA CALON PENGANTIN PRIA               │
│ [Nama Lengkap________]                  │
│ [NIK 16 digit________] [Ttl Lahir____] │
│ [Tempat Lahir_______] [Tgl Lahir____] │
│ [Alamat________________...]            │
├─────────────────────────────────────────┤
│ DATA CALON PENGANTIN WANITA             │
│ [Nama Lengkap________]                  │
│ [NIK 16 digit________] [Ttl Lahir____] │
│ [Tempat Lahir_______] [Tgl Lahir____] │
│ [Alamat________________...]            │
├─────────────────────────────────────────┤
│ DETAIL PERNIKAHAN                       │
│ [Tgl Nikah_________] [Tempat Nikah___] │
│ [Nama Saksi 1_____] [Nama Saksi 2___] │
├─────────────────────────────────────────┤
│           [Submit Pengajuan]            │
└─────────────────────────────────────────┘
```

#### **Error Handling**

```
- NIK tidak ditemukan di KTP API
  → "Data KTP tidak ditemukan"

- Umur < 19 tahun
  → "Umur harus minimal 19 tahun"

- Sudah menikah (status_perkawinan = Kawin)
  → "Status perkawinan harus belum menikah"

- Gender sama (keduanya L atau P)
  → "Pasangan harus berbeda gender"

- API timeout
  → "Gagal mengakses API KTP"

- Field validation error
  → Custom error message per field
```

---

### **2. History & Status Pengajuan** ✅ SUDAH ADA

**File**: [resources/views/marriage/status.blade.php](resources/views/marriage/status.blade.php)

#### **Halaman Status**

```
Route: GET /marriage/status
Controller: MarriageController::status()

Proses:
1. Query: Marriage::where('created_by', auth()->id())
2. Order by created_at descending
3. Return view dengan data marriages
```

#### **Tampilan Status Table**

```
┌──────────────────────────────────────────────────────────┐
│ Status Pengajuan Buku Nikah                              │
├──────────────────────────────────────────────────────────┤
│ No | Pengantin          | Tanggal Nikah | Status | Tgl   │
├──────────────────────────────────────────────────────────┤
│ 1  | Budi ♥ Siti        | 25 Dec 2025   | ✓ Aktif | 15D  │
│ 2  | Ahmad ♥ Nur        | 30 Jan 2026   | ✓ Aktif | 10D  │
│ 3  | Rian ♥ Dina        | 28 Feb 2026   | ⏸ Nonaktif     │
└──────────────────────────────────────────────────────────┘
```

#### **Status Warna Indikator**

```
🟢 ACTIVE (Aktif)       → Status pengajuan sedang berlangsung
🟡 INACTIVE (Nonaktif)  → Status ditangguhkan
🔴 CANCELLED (Dibatalkan) → Pengajuan dibatalkan
```

#### **Informasi yang Ditampilkan**

```
Per Baris:
- No. urut
- Nama Calon Pengantin Pria ♥ Nama Calon Pengantin Wanita
- Tanggal Pernikahan (format: dd MMM YYYY)
- Status dengan icon
- Tanggal Pengajuan (format: dd MMM YYYY HH:mm)
```

#### **Fitur Tambahan**

```
✅ Jika ada pengajuan → Tampilkan table dengan data
✅ Jika belum ada pengajuan → Tampilkan empty state dengan tombol "Buat Pengajuan Baru"
✅ Tombol "Buat Pengajuan Baru" di bawah table
✅ Success message jika baru saja submit
```

---

### **3. Print Hasil Buku Nikah** ❌ BELUM ADA

**Status**: Fitur ini **BELUM DIIMPLEMENTASIKAN**

#### **Yang Diperlukan:**

1. **Controller Method**

    ```php
    // Tambah di MarriageController
    public function print($id)
    {
        $marriage = Marriage::find($id);
        abort_if($marriage->created_by !== Auth::id(), 403);

        return view('marriage.print', compact('marriage'));
    }
    ```

2. **Route Baru**

    ```php
    Route::get('/marriage/print/{id}', [MarriageController::class, 'print'])
         ->name('marriage.print');
    ```

3. **View Print**

    ```
    resources/views/marriage/print.blade.php
    - Layout khusus untuk print
    - Design mirip buku nikah resmi
    - Include semua data pernikahan
    - Custom styling untuk A4 paper
    ```

4. **Fitur Print**
    - Button "Print" di status page
    - PDF download (optional dengan library dompdf)
    - Print preview sebelum print
    - Styling landscape/portrait

---

## 🔄 User Workflow Lengkap

```
┌─────────────────────────────────────────────────────────────┐
│ USER PERNIKAHAN - COMPLETE FLOW                             │
└─────────────────────────────────────────────────────────────┘

1. LOGIN
   ↓
2. AKSES /marriage/request
   ↓
3. INPUT NIK (Verifikasi API KTP)
   - POST /marriage/search-nik
   - Validasi age, gender, marital status
   - Form prefilled dengan data API
   ↓
4. LENGKAPI FORM DETAIL
   - Data lengkap dari form
   - POST /marriage/request
   ↓
5. SUBMIT PENGAJUAN
   - Marriage record dibuat (status='active')
   - Redirect ke /marriage/status
   ↓
6. LIHAT STATUS PENGAJUAN
   - GET /marriage/status
   - Table dengan history semua pengajuan
   ↓
7. [FUTURE] PRINT BUKU NIKAH
   - GET /marriage/print/{id}
   - View atau PDF hasil buku nikah
   ↓
8. SELESAI
```

---

## 📊 Data Flow Diagram

### **Pengajuan Pernikahan**

```
┌──────────────┐
│ User        │
└──────┬───────┘
       │
       ├─ Input NIK Pria & Wanita
       │  ↓
       ├─ POST /marriage/search-nik
       │  ↓
       ├─ KtpApiService::getKtpByNik() x2
       │  ├─ Call API: /api/ktp/nik/{nik}
       │  ├─ Validate age >= 19
       │  ├─ Validate status != "Kawin"
       │  └─ Format data
       │  ↓
       ├─ Session prefill = [groom, bride]
       │  ↓
       ├─ GET /marriage/request (form prefilled)
       │  ↓
       ├─ Lengkapi form:
       │  - Marriage date, place
       │  - Witness 1 & 2
       │  ↓
       ├─ POST /marriage/request
       │  ↓
       ├─ Marriage::create()
       │  ├─ status = 'active'
       │  ├─ created_by = Auth::id()
       │  ├─ All fields stored
       │  └─ Flush session
       │  ↓
       └─ Redirect to /marriage/status
          ↓
      ┌─────────────────┐
      │ Status Page     │
      │ - Table history │
      │ - Status badge  │
      │ - New request   │
      │   button        │
      └─────────────────┘
```

---

## 🎯 Next Steps untuk Implementasi Print

### **Option 1: Simple HTML Print**

```php
// Controller
public function print($id)
{
    $marriage = Marriage::findOrFail($id);
    abort_if($marriage->created_by !== Auth::id(), 403);

    return view('marriage.print', compact('marriage'));
}
```

```html
<!-- View: resources/views/marriage/print.blade.php -->
<style media="print">
    @page {
        size: A4;
        margin: 20mm;
    }
</style>

<!-- Buku Nikah Layout -->
<div class="buku-nikah">
    <!-- Header -->
    <!-- Detail Pernikahan -->
    <!-- Tanda Tangan -->
</div>

<script>
    window.print();
</script>
```

### **Option 2: Generate PDF dengan DomPDF**

```bash
composer require barryvdh/laravel-dompdf
```

```php
use Barryvdh\DomPDF\Facade\Pdf;

public function printPdf($id)
{
    $marriage = Marriage::findOrFail($id);
    abort_if($marriage->created_by !== Auth::id(), 403);

    $pdf = Pdf::loadView('marriage.print-pdf', compact('marriage'));
    return $pdf->download('buku_nikah_'.$marriage->id.'.pdf');
}
```

### **Option 3: Add Print Button di Status Page**

```html
<!-- Di status.blade.php -->
<a
    href="{{ route('marriage.print', $marriage->id) }}"
    class="px-3 py-1 bg-blue-500 text-white rounded"
>
    <i class="fas fa-print"></i> Print
</a>
```

---

## 📱 Mobile-Friendly Features

✅ **Request Form**

-   Responsive grid (1 col mobile, 2 col desktop)
-   Touch-friendly input fields
-   Clear error messages

✅ **Status Page**

-   Horizontal scroll table untuk mobile
-   Collapsible rows untuk mobile
-   Clear status badges

---

## 🔐 Security Checks

✅ **Authorization**

-   User hanya bisa lihat pengajuan mereka sendiri
-   `where('created_by', Auth::id())`
-   Cek di print juga

✅ **Input Validation**

-   Server-side validation di semua routes
-   Regex untuk NIK: `^\d{16}$`
-   Required fields
-   Date validation (marriage_date >= today)

✅ **API Integration**

-   Timeout 30 seconds
-   Error handling & logging
-   Safe data extraction

---

## 📝 Summary

| Fitur              | Status  | Lokasi                                       |
| ------------------ | ------- | -------------------------------------------- |
| Form Pengajuan     | ✅ DONE | MarriageController, request-form.blade.php   |
| Verifikasi NIK API | ✅ DONE | KtpApiService, MarriageController::searchNik |
| Status & History   | ✅ DONE | MarriageController::status, status.blade.php |
| Print Buku Nikah   | ❌ TODO | -                                            |
| PDF Export         | ❌ TODO | -                                            |
| Email Notification | ❌ TODO | -                                            |

---

## 🚀 Rekomendasi

1. **Immediate**: Implementasi Print Fitur (Priority 1)
2. **Next**: Email notification ketika status berubah
3. **Future**: Export ke PDF, QR code, digitally signed
4. **Nice to have**: Approval workflow untuk admin
