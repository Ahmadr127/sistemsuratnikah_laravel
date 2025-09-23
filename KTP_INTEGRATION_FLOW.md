# Alur Integrasi API KTP

## Diagram Alur Sistem

```mermaid
graph TD
    A[Admin Login] --> B[Dashboard Admin]
    B --> C[Klik 'Buat Buku Nikah']
    C --> D[Form Input NIK]
    D --> E[Submit NIK]
    E --> F[KtpApiService.getKtpByNik]
    F --> G{API Response}
    G -->|Success| H[Validasi Data KTP]
    G -->|Error| I[Tampilkan Error]
    H --> J{Status KTP = 'selesai'?}
    J -->|No| K[Error: KTP belum selesai]
    J -->|Yes| L{Status Perkawinan = 'Belum Kawin'?}
    L -->|No| M[Error: Sudah menikah]
    L -->|Yes| N[Format Data untuk Form]
    N --> O[Tampilkan Form Pernikahan]
    O --> P[Admin Lengkapi Data Pernikahan]
    P --> Q[Simpan Data Pernikahan]
    Q --> R[Berhasil - Redirect ke Daftar Pernikahan]
    
    I --> D
    K --> D
    M --> D
```

## Diagram Komponen Sistem

```mermaid
graph LR
    A[AdminController] --> B[KtpApiService]
    B --> C[API KTP External]
    A --> D[Marriage Model]
    A --> E[User Model]
    B --> F[KtpData Model]
    
    G[View: ktp-data.blade.php] --> A
    H[View: ktp-detail.blade.php] --> A
    I[View: marriage/form.blade.php] --> A
    
    J[Route: /admin/ktp-data] --> A
    K[Route: /admin/ktp-search] --> A
    L[Route: /admin/marriage/search-nik] --> A
```

## Diagram Validasi Data

```mermaid
flowchart TD
    A[Input NIK] --> B{Format NIK Valid?}
    B -->|No| C[Error: Format NIK tidak valid]
    B -->|Yes| D[Call API KTP]
    D --> E{API Response Success?}
    E -->|No| F[Error: Data tidak ditemukan]
    E -->|Yes| G{Status KTP = 'selesai'?}
    G -->|No| H[Error: KTP belum selesai]
    G -->|Yes| I{Status Perkawinan = 'Belum Kawin'?}
    I -->|No| J[Error: Sudah menikah]
    I -->|Yes| K{Usia >= 19 tahun?}
    K -->|No| L[Error: Usia belum memenuhi syarat]
    K -->|Yes| M[Data Valid - Lanjut ke Form]
    
    C --> A
    F --> A
    H --> A
    J --> A
    L --> A
```

## Diagram Database Schema

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email
        string password
        string role
        timestamp created_at
        timestamp updated_at
    }
    
    MARRIAGES {
        bigint id PK
        string groom_nik
        string groom_name
        date groom_birth_date
        string groom_birth_place
        text groom_address
        string bride_nik
        string bride_name
        date bride_birth_date
        string bride_birth_place
        text bride_address
        date marriage_date
        string marriage_place
        string witness1_name
        string witness2_name
        string status
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }
    
    KTP_DATA {
        bigint id PK
        string ktp_id
        bigint user_id
        string no_pengajuan
        string nik
        string nama_lengkap
        string tempat_lahir
        date tanggal_lahir
        string jenis_kelamin
        string golongan_darah
        string agama
        string status_perkawinan
        string pekerjaan
        string kewarganegaraan
        text alamat
        string provinsi
        string kabupaten
        string kecamatan
        string kelurahan
        string rt
        string rw
        string kode_pos
        string no_telepon
        string status
        text catatan
        datetime tanggal_pengajuan
        datetime tanggal_selesai
        string user_name
        string user_email
        timestamp created_at
        timestamp updated_at
    }
    
    USERS ||--o{ MARRIAGES : creates
    USERS ||--o{ KTP_DATA : owns
```

## Diagram API Integration

```mermaid
sequenceDiagram
    participant A as Admin
    participant C as Controller
    participant S as KtpApiService
    participant API as KTP API
    participant DB as Database
    
    A->>C: Input NIK Calon Pengantin
    C->>S: getKtpByNik(nik)
    S->>API: GET /api/ktp/nik/{nik}
    API-->>S: Response JSON
    S->>S: validateKtpForMarriage()
    S-->>C: Formatted Data
    C->>C: Store in Session
    C-->>A: Show Marriage Form
    A->>C: Submit Marriage Data
    C->>DB: Save Marriage Record
    C-->>A: Success Message
```

## Status Flow KTP

```mermaid
stateDiagram-v2
    [*] --> pending: Pengajuan KTP
    pending --> verifikasi: Dokumen Lengkap
    verifikasi --> proses_cetak: Data Valid
    verifikasi --> ditolak: Data Tidak Valid
    proses_cetak --> selesai: KTP Dicetak
    ditolak --> [*]: Perbaiki Dokumen
    selesai --> [*]: KTP Siap
    
    note right of selesai: Status ini yang valid untuk pernikahan
    note right of ditolak: Perlu perbaikan dokumen
```

## Error Handling Flow

```mermaid
flowchart TD
    A[API Call] --> B{Network OK?}
    B -->|No| C[Network Error]
    B -->|Yes| D{HTTP Status 200?}
    D -->|No| E[HTTP Error]
    D -->|Yes| F{Response.success = true?}
    F -->|No| G[API Error Response]
    F -->|Yes| H{Data Exists?}
    H -->|No| I[Data Not Found]
    H -->|Yes| J[Process Data]
    
    C --> K[Log Error]
    E --> K
    G --> K
    I --> K
    K --> L[Return Error to User]
    J --> M[Return Success]
```
