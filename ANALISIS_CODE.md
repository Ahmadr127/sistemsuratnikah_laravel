# 📋 Analisis Code - Sistem Surat Nikah Laravel

## 🎯 Ringkasan Aplikasi
**Sistem Surat Nikah** adalah aplikasi berbasis Laravel untuk mengelola pendaftaran pernikahan dengan integrasi KTP API. Aplikasi ini memungkinkan user biasa untuk mengajukan pernikahan dan admin untuk mengelola data pernikahan serta data KTP.

---

## 🏗️ Arsitektur Aplikasi

### **Stack Teknologi**
- **Framework**: Laravel (PHP)
- **Database**: SQL (MySQL/PostgreSQL)
- **Frontend**: Blade Template + HTML/CSS/JavaScript
- **API Integration**: KTP API (eksternal)
- **Authentication**: Laravel Auth + PIN Verification
- **Roles**: Admin & User

---

## 📊 Database Schema

### **Tabel Users**
```
- id (PK)
- name (string)
- username (unique, string)
- email (unique, string)
- password (hashed)
- gender (L/P)
- role (admin/user)
- email_verified_at (nullable)
- created_at, updated_at
```

### **Tabel Marriages**
```
- id (PK)
- groom_nik (16 digits)
- groom_name, groom_birth_date, groom_birth_place, groom_address
- bride_nik (16 digits)
- bride_name, bride_birth_date, bride_birth_place, bride_address
- marriage_date
- marriage_place
- witness1_name, witness2_name
- status (active/inactive)
- created_by (FK -> users.id)
- created_at, updated_at
```

### **Tabel Verification Codes**
```
- id (PK)
- user_id (FK, nullable)
- email
- type (register/password_reset)
- code_hash (hashed PIN)
- attempts (counter)
- expires_at (10 menit default)
- consumed_at (nullable, tandai sudah dipakai)
- created_at, updated_at
```

### **Tabel KTP Data**
```
- id (PK)
- ktp_id (eksternal API ID)
- user_id, nik, nama_lengkap
- tempat_lahir, tanggal_lahir
- jenis_kelamin, golongan_darah, agama
- status_perkawinan, pekerjaan, kewarganegaraan
- alamat, provinsi, kabupaten, kecamatan, kelurahan
- rt, rw, kode_pos, no_telepon
- file paths: akta_kelahiran, kartu_keluarga, pas_foto
- status (selesai/pending)
- catatan, tanggal_pengajuan, tanggal_selesai
- created_at, updated_at
```

---

## 🔐 Authentication Flow

### **1️⃣ Registrasi**
```
User Input
  ↓
POST /register
  ↓ [AuthController::register()]
Validasi Data (name, username, email, password, gender)
  ↓
Hash Password & Create User (role='user')
  ↓
Generate 4-digit PIN
  ↓
Email PIN ke User (VerificationPinMail)
  ↓
Redirect ke /verify-pin dengan type=register
  ↓
User masukkan PIN
  ↓ [VerificationController::verifyPin()]
Validasi PIN & Tandai consumed_at
  ↓
Auth::login() → Auto login user
  ↓
Redirect ke Home (/)
```

### **2️⃣ Login**
```
User Input
  ↓
POST /login
  ↓ [AuthController::login()]
Deteksi field: email atau username
  ↓
Cari user di DB
  ↓
Hash::check(password) → Valid?
  ↓ Ya
Auth::login() + Regenerate Session
  ↓
Redirect ke "/" atau intended page
  ↓ Tidak
Redirect back with error
```

### **3️⃣ Lupa Password (PIN-based Reset)**
```
User klik "Lupa Password"
  ↓
GET /forgot-password
  ↓
Masukkan Email
  ↓
POST /forgot-password
  ↓ [VerificationController::sendResetPin()]
Cari user by email
  ↓
Generate PIN baru (jika ada PIN lama, delete)
  ↓
Email PIN
  ↓
Redirect ke /verify-pin dengan type=password_reset
  ↓
User verifikasi PIN
  ↓ [VerificationController::verifyPin() - TYPE_PASSWORD_RESET]
Tandai PIN consumed
  ↓
Redirect ke /reset-password
  ↓
POST /reset-password
  ↓ [VerificationController::resetPassword()]
Update password user
  ↓
Redirect ke login dengan success message
```

---

## 🎭 Role-Based Access

### **Middleware: AdminMiddleware**
```php
if (!auth()->check()) → Redirect ke login
if (!auth()->user()->isAdmin()) → Abort 403 (Forbidden)
```

### **User (role='user')**
✅ Akses:
- `/` (home)
- `/marriage/request` - Ajukan pernikahan
- `/marriage/search-nik` - Cari NIK via KTP API
- `/marriage/status` - Lihat status pernikahan
- `/login`, `/register`, `/logout`
- `/forgot-password`, `/verify-pin`, `/reset-password`

### **Admin (role='admin')**
✅ Akses:
- Semua akses user
- `/admin/dashboard` - Dashboard admin
- `/admin/users` - Kelola user
- `/admin/marriages` - Kelola pernikahan
- `/admin/marriage/create` - Buat pernikahan baru
- `/admin/marriage/search-nik` - Cari NIK (admin)
- `/admin/ktp-data` - Lihat data KTP
- `/admin/home-settings/edit` - Edit home settings

---

## 🛣️ Route Mapping

### **Public Routes (Guest)**
```
GET  /                              → HomeController::index()
GET  /login                         → View auth.auth
GET  /register                      → View auth.auth
POST /login                         → AuthController::login()
POST /register                      → AuthController::register()
GET  /forgot-password               → VerificationController::showForgotForm()
POST /forgot-password               → VerificationController::sendResetPin()
GET  /verify-pin                    → VerificationController::showVerifyForm()
POST /verify-pin                    → VerificationController::verifyPin()
GET  /reset-password                → VerificationController::showResetForm()
POST /reset-password                → VerificationController::resetPassword()
POST /logout                        → AuthController::logout()
```

### **User Routes (Authenticated)**
```
GET  /marriage/request              → MarriageController::showRequestForm()
POST /marriage/search-nik           → MarriageController::searchNik()
POST /marriage/request              → MarriageController::submitRequest()
GET  /marriage/status               → MarriageController::status()
```

### **Admin Routes (Authenticated + AdminMiddleware)**
```
GET  /admin/dashboard               → AdminController::dashboard()
GET  /admin/users                   → AdminController::users()
GET  /admin/marriages               → AdminController::marriages()
GET  /admin/marriage/create         → AdminController::createMarriage()
POST /admin/marriage/search-nik     → AdminController::searchNik()
GET  /admin/marriage/create-form    → AdminController::createMarriageForm()
POST /admin/marriage/store          → AdminController::storeMarriage()
GET  /admin/ktp-data                → AdminController::ktpData()
POST /admin/ktp/search              → AdminController::searchKtp()
GET  /admin/home-settings/edit      → AdminHomeSettingController::edit()
POST /admin/home-settings/update    → AdminHomeSettingController::update()
```

---

## 🔗 Controller & Logic Flow

### **1. AuthController**

#### `register(Request $request)`
```
Input: name, username, email, password, gender
↓
Validasi:
- name: required, string, max 255
- username: unique, alphanumeric, 3-30 chars
- email: unique, valid format
- password: min 8 chars, confirmed
- gender: L atau P
↓
Create User dengan role='user'
↓
Generate PIN via VerificationCode::generate()
↓
Send Email via VerificationPinMail
↓
Store session: pin_flow = [type=>register, email=>...]
↓
Return: redirect to /verify-pin
```

#### `login(Request $request)`
```
Input: email (bisa email atau username), password
↓
Deteksi jenis field (email atau username)
↓
User::where(field, value)->first()
↓
Hash::check(password)?
↓ Ya: Auth::login() + regenerate session
    Return: redirect()->intended('/')
↓ Tidak: return back with error
```

#### `logout(Request $request)`
```
Auth::logout()
↓
Session::invalidate() + regenerateToken()
↓
Redirect ke '/'
```

---

### **2. VerificationController**

#### `sendResetPin(Request $request)` → TYPE_PASSWORD_RESET
```
Input: email
↓
User::where('email', email)->first()
  Jika tidak ada → Error "Email tidak terdaftar"
↓
Generate PIN baru
↓
Email PIN
↓
Store session
↓
Redirect ke /verify-pin dengan type=password_reset
```

#### `verifyPin(Request $request)`
```
Input: email, type (register/password_reset), pin
↓
Cari VerificationCode:
  WHERE email = ? AND type = ? AND consumed_at IS NULL
  ORDER BY id DESC
↓
checkAndConsume(pin):
  - Check expired? (10 menit dari expires_at)
  - Check consumed?
  - Check attempts >= 5?
  - Hash::check(pin, code_hash)?
  ↓ Valid: Set consumed_at = NOW(), increment attempts
  ↓ Invalid: Increment attempts saja
↓
Jika type = 'register':
  Auth::login(user)
  Redirect ke '/' dengan success
↓
Jika type = 'password_reset':
  Store session untuk reset form
  Redirect ke /reset-password
```

#### `resetPassword(Request $request)` → TYPE_PASSWORD_RESET
```
Input: password, password_confirmation
↓
Cek session untuk password_reset flow
↓
Update user->password = Hash::make(password)
↓
Redirect ke login dengan success
```

---

### **3. MarriageController** (User)

#### `searchNik(Request $request)`
```
Input: groom_nik, bride_nik (16 digit)
↓
Validasi NIK format
↓
Call KtpApiService::getKtpByNik(groom_nik)
Call KtpApiService::getKtpByNik(bride_nik)
↓
API success?
  ↓ Tidak: Return errors
↓
Validasi marriage eligibility:
  KtpApiService::validateKtpForMarriage(data)
  (Check: age >= 19, status != Kawin, gender beda)
  ↓
Format data:
  KtpApiService::formatKtpForMarriage(data)
↓
Store session:
  marriage_prefill = [groom => {...}, bride => {...}]
↓
Redirect ke /marriage/request dengan success
```

#### `submitRequest(Request $request)`
```
Input: Semua detail pernikahan + saksi
  - groom_name, groom_nik, groom_birth_date, ...
  - bride_name, bride_nik, bride_birth_date, ...
  - marriage_date, marriage_place
  - witness1_name, witness2_name
↓
Validasi semua field
↓
Marriage::create([...])
  Status default: 'active'
  created_by: auth()->user()->id
↓
Clear session: marriage_prefill
↓
Redirect ke /marriage/status dengan success
```

#### `status()`
```
Ambil marriage data user:
  Marriage::where('created_by', auth()->id())->get()
↓
Return view dengan marriage status
```

---

### **4. AdminController**

#### `dashboard()`
```
Hitung stats:
- total_users = User::count()
- total_admins = User::where('role', 'admin')->count()
- total_regular_users = User::where('role', 'user')->count()
- total_marriages = Marriage::count()
↓
Ambil recent data:
- recent_users = User::latest()->take(5)->get()
- recent_marriages = Marriage::latest()->take(5)->get()
↓
Return view admin.dashboard
```

#### `users()` & `marriages()`
```
users():
  $users = User::paginate(10)
  Return view admin.users
↓
marriages():
  $marriages = Marriage::with('createdBy')->paginate(10)
  Return view admin.marriages
```

#### `searchNik(Request $request)` → Admin Version
```
Sama seperti MarriageController::searchNik()
BUT:
↓
Store session dengan key 'marriage_data' (lebih lengkap)
Termasuk: groom_ktp_data, bride_ktp_data (full API response)
↓
Redirect ke /admin/marriage/create-form
```

#### `createMarriageForm()`
```
Ambil session marriage_data
↓
Jika tidak ada → Redirect dengan error
↓
Return view admin.marriage.form dengan prefill data
```

#### `storeMarriage(Request $request)`
```
Sama seperti MarriageController::submitRequest()
BUT:
↓
created_by = auth()->user()->id (admin yang buat)
↓
Redirect ke /admin/marriages
```

#### `ktpData()` & `searchKtp()`
```
ktpData():
  Call KtpApiService::getAllKtp()
  $ktp_data = response['data']
  Return view admin.ktp-data
↓
searchKtp():
  Input: search query (nik/nama)
  Filter data dari getAllKtp()
  Return filtered results
```

---

### **5. KtpApiService**

#### `getKtpByNik($nik)`
```
Validasi format NIK (16 digit)
↓
HTTP::timeout(30)->get(
  "https://ktp.chasouluix.biz.id/api/ktp/nik/{nik}"
)
↓
Parse response:
{
  success: true/false,
  data: {
    nik, nama_lengkap, tempat_lahir, tanggal_lahir,
    jenis_kelamin, golongan_darah, agama,
    status_perkawinan, pekerjaan, kewarganegaraan,
    alamat, provinsi, kabupaten, kecamatan, kelurahan,
    rt, rw, kode_pos, no_telepon
  },
  message: "..."
}
↓
Return formatted response array
```

#### `validateKtpForMarriage($ktpData)`
```
Check:
1. Umur >= 19 tahun?
   Dari tanggal_lahir, hitung umur
   ↓
2. Belum menikah?
   status_perkawinan !== 'Kawin'
   ↓
Return:
{
  valid: true/false,
  message: "error message jika invalid"
}
```

#### `formatKtpForMarriage($ktpData)`
```
Transform KTP API response ke format form:
{
  name: nama_lengkap,
  nik: nik,
  birth_date: tanggal_lahir (formatted),
  birth_place: tempat_lahir,
  address: alamat,
  gender: jenis_kelamin,
  ...
}
```

#### `getAllKtp()`
```
HTTP::get("base_url/all")
↓
Parse dan return semua data KTP dari API
```

---

## 📱 View Structure

### **Guest/Public Views**
```
resources/views/
├── welcome.blade.php           ← Homepage
├── home.blade.php              ← Home untuk authenticated user
├── auth/
│   ├── auth.blade.php          ← Login/Register form (unified)
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   └── verify-pin.blade.php    ← PIN verification form
├── emails/
│   └── verification-pin.blade.php ← Email template
```

### **User Views**
```
└── marriage/
    ├── request-form.blade.php  ← Form ajukan pernikahan
    └── status.blade.php        ← Status pernikahan user
```

### **Admin Views**
```
└── admin/
    ├── dashboard.blade.php
    ├── users.blade.php
    ├── marriages.blade.php
    ├── ktp-data.blade.php
    ├── ktp-detail.blade.php
    ├── home-settings/
    │   └── edit.blade.php
    └── marriage/
        ├── create.blade.php    ← Pilih untuk cari NIK
        ├── form.blade.php      ← Form lengkapi detail (after search)
```

### **Layout**
```
└── layouts/
    ├── app.blade.php           ← Default layout
    └── admin.blade.php         ← Admin layout
```

---

## 🔄 Key Data Flow Diagrams

### **Complete Marriage Registration Flow (User)**
```
1. User Login
   ↓
2. Access /marriage/request
   ↓
3. Input groom_nik & bride_nik
   ↓
4. POST /marriage/search-nik
   ├─ Validate NIK format
   ├─ Call KTP API untuk groom
   ├─ Call KTP API untuk bride
   ├─ Validate age & marital status
   └─ Format data untuk form
   ↓
5. Session stored: marriage_prefill = [groom, bride]
   ↓
6. Form prefilled dengan data KTP
   ↓
7. User lengkapi form:
   - marriage_date, marriage_place
   - witness names
   ↓
8. POST /marriage/request (submitRequest)
   ├─ Validate all fields
   └─ Marriage::create()
   ↓
9. Redirect ke /marriage/status
   ↓
10. View status pernikahan (admin akan lihat di /admin/marriages)
```

### **KTP API Integration Flow**
```
MarriageController / AdminController
  ↓
KtpApiService::getKtpByNik(nik)
  ├─ Validate NIK format
  └─ HTTP GET /api/ktp/nik/{nik}
  ↓
External KTP API (ktp.chasouluix.biz.id)
  ├─ Lookup database KTP
  └─ Return JSON response
  ↓
Service::formatKtpForMarriage()
  ├─ Extract required fields
  └─ Map ke form fields
  ↓
Service::validateKtpForMarriage()
  ├─ Check age >= 19
  ├─ Check status_perkawinan
  └─ Return validation result
  ↓
Controller return status & data ke view
```

---

## 🔐 Security Features

### **1. Authentication & Authorization**
- ✅ Hash password (bcrypt)
- ✅ Session management
- ✅ Role-based access (User vs Admin)
- ✅ AdminMiddleware untuk protected routes
- ✅ 'auth' middleware untuk authenticated users
- ✅ 'guest' middleware untuk login/register

### **2. PIN Verification**
- ✅ 4-digit PIN generate random
- ✅ Hash PIN dengan bcrypt
- ✅ 10 menit expiration
- ✅ Max 5 attempts
- ✅ consumed_at flag untuk prevent reuse
- ✅ Email delivery

### **3. Input Validation**
- ✅ Server-side validation di setiap route
- ✅ NIK format: exactly 16 digits
- ✅ Email format validation
- ✅ Password minimum 8 chars
- ✅ Username alphanumeric
- ✅ Custom error messages (Indonesia)

### **4. Data Protection**
- ✅ Password hashed sebelum store
- ✅ PIN hashed sebelum store
- ✅ Sensitive data di 'hidden' array
- ✅ Mass assignment protection via $fillable

### **5. API Security**
- ✅ Timeout 30 seconds
- ✅ Error logging
- ✅ Graceful error handling
- ✅ Validation sebelum API call

---

## 📊 Model Relationships

```
User
├─ has many Marriage (as createdBy)
├─ has many VerificationCode
└─ has many KtpData

Marriage
└─ belongs to User (createdBy)

VerificationCode
└─ belongs to User

KtpData
└─ belongs to User (optional)
```

---

## 🎯 Key Features Summary

| Feature | User | Admin |
|---------|------|-------|
| Registration | ✅ | ✅ |
| Login | ✅ | ✅ |
| Forgot Password (PIN) | ✅ | ✅ |
| Request Marriage | ✅ | ❌ |
| View Marriage Status | ✅ | ❌ |
| Create Marriage | ❌ | ✅ |
| Manage Marriages | ❌ | ✅ |
| Manage Users | ❌ | ✅ |
| View KTP Data | ❌ | ✅ |
| Home Settings | ❌ | ✅ |

---

## 🚀 How to Use

### **1. Register as User**
```
GET /register → Input form → POST /register
↓
Verify PIN via email → Redirect home (auto login)
```

### **2. Request Marriage (as User)**
```
GET /marriage/request
↓
Input groom & bride NIK
↓
POST /marriage/search-nik → Validate via KTP API
↓
GET /marriage/request (form prefilled)
↓
Complete form → POST /marriage/request
↓
GET /marriage/status → View status
```

### **3. Manage Marriage (as Admin)**
```
GET /admin/marriage/create
↓
Input groom & bride NIK
↓
POST /admin/marriage/search-nik
↓
GET /admin/marriage/create-form
↓
Complete form → POST /admin/marriage/store
↓
GET /admin/marriages → View all
```

---

## 🐛 Error Handling

```
- PIN expired/invalid/consumed → "Kode tidak valid atau sudah kedaluwarsa"
- NIK not found → "Data KTP tidak ditemukan"
- Age too young → "Umur harus minimal 19 tahun"
- Already married → "Status perkawinan harus belum menikah"
- API timeout → "Gagal mengakses API KTP"
- Invalid credentials → "Username/Email atau password salah"
- Unauthorized admin → "Akses ditolak. Hanya admin..."
```

---

## 📝 Notes

1. **KTP API**: External service yang menyimpan data KTP seluruh Indonesia
2. **PIN System**: Digunakan untuk register verification dan password reset
3. **Marriage Status**: Default 'active' ketika dibuat
4. **Session-based**: Prefill data disimpan di session (tidak persisten)
5. **Gender**: 'L' (Laki-laki) atau 'P' (Perempuan)
6. **Multiple Login**: Bisa pakai email atau username untuk login

---

## 📌 File Structure Quick Reference

```
app/
├── Http/Controllers/
│   ├── AuthController.php          ← Register, Login, Logout
│   ├── VerificationController.php  ← PIN verification & Reset
│   ├── MarriageController.php      ← User marriage requests
│   ├── AdminController.php         ← Admin features
│   └── AdminHomeSettingController.php
├── Models/
│   ├── User.php
│   ├── Marriage.php
│   ├── VerificationCode.php
│   └── KtpData.php
├── Services/
│   └── KtpApiService.php           ← KTP API integration
└── Middleware/
    └── AdminMiddleware.php

routes/
└── web.php                          ← All routes definition

database/
├── migrations/                      ← Table schemas
└── seeders/
    └── AdminUserSeeder.php

resources/views/                     ← All templates
```

---

**Document Version**: 1.0  
**Last Updated**: Dec 2025  
**Language**: Bahasa Indonesia + English
