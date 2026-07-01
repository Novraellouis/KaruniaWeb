qw# Firebase Authentication Setup Guide

Panduan lengkap setup Google login/register/forgot password dengan Firebase untuk lokal dan production.

## Step 1: Buat Firebase Project

1. Buka https://firebase.google.com
2. Klik **Go to console** (atau langsung ke https://console.firebase.google.com)
3. Klik **Add project** atau **Create a project**
4. Input nama project: `KaruniaSipoholon` (atau nama apapun)
5. Klik **Continue**
6. Disable Google Analytics (opsional), klik **Create project**
7. Tunggu project siap (~1-2 menit)

## Step 2: Setup Firebase Authentication

1. Di Firebase Console, pilih project Anda
2. Di sidebar kiri, klik **Build** → **Authentication**
3. Klik **Get Started**
4. Pilih **Google** dari daftar provider
5. Enable Google provider
6. Di **Web SDK configuration**, akan tampil:
   - Project ID
   - Web API Key
   - Auth Domain
7. Klik **Save** dan **Go back**

## Step 3: Dapatkan Firebase Config

1. Di Firebase Console, klik gear icon (⚙️) → **Project settings**
2. Scroll ke bagian **Your apps** 
3. Klik Web app (</> icon) atau **Add app** → pilih Web
4. Copy konfigurasi Firebase:
```javascript
{
  "apiKey": "AIzaSy...",
  "authDomain": "your-project.firebaseapp.com",
  "projectId": "your-project",
  "storageBucket": "your-project.appspot.com",
  "messagingSenderId": "123456789",
  "appId": "1:123456789:web:abc..."
}
```

## Step 4: Update .env File

Buka file `.env` dan ubah/tambahkan variabel Firebase:

```bash
FIREBASE_API_KEY=AIzaSy...
FIREBASE_AUTH_DOMAIN=your-project.firebaseapp.com
FIREBASE_PROJECT_ID=your-project
FIREBASE_STORAGE_BUCKET=your-project.appspot.com
FIREBASE_MESSAGING_SENDER_ID=123456789
FIREBASE_APP_ID=1:123456789:web:abc...
```

**Ganti value dengan nilai dari Firebase Console Anda.**

## Step 5: Setup Authorized Domains di Firebase

1. Di Firebase Console → **Authentication** → **Settings** tab
2. Scroll ke **Authorized domains**
3. Tambahkan domain:
   - Untuk **LOCAL**: `localhost:8000`
   - Untuk **PRODUCTION**: `your-domain.com` (tanpa https://)

## Step 6: Setup Google OAuth Consent Screen (Optional)

Jika mau app publish dan tidak hanya testing:

1. Buka Google Cloud Console: https://console.cloud.google.com
2. Pilih project yang sama
3. Di sidebar → **APIs & Services** → **OAuth consent screen**
4. Pilih **External** → **Create**
5. Isi:
   - **App name**: Karunia Sipoholon
   - **User support email**: your-email@example.com
   - **Developer contact**: your-email@example.com
6. Klik **Save and Continue**
7. Di **Scopes**, klik **Add or Remove Scopes** dan pilih:
   - `email`
   - `profile`
   - `openid`
8. Klik **Update** → **Save and Continue**
9. Klik **Save and Continue** lagi
10. Selesai — consent screen sudah ready

## Step 7: Test Lokal

1. Buka terminal di project folder
2. Jalankan server:
```bash
php artisan serve
```

3. Buka http://localhost:8000/auth (login page)
4. Klik tombol **"Masuk dengan Google"**
5. Pilih akun Google Anda
6. Jika berhasil, akan redirect ke dashboard

## Step 8: Production Deployment

Saat deploy ke production:

1. Update `.env` di server dengan nilai Firebase baru (jika perlu project ID berbeda)
2. Pastikan domain production sudah ditambahkan ke **Authorized domains** di Firebase
3. Jalankan:
```bash
php artisan config:clear
php artisan cache:clear
```

## Fitur yang Tersedia

✅ **Login dengan Google** - `http://localhost:8000/auth`
✅ **Register dengan Google** - `http://localhost:8000/auth/register`
✅ **Forgot Password dengan Google** - `http://localhost:8000/auth/forgot`

Semua fitur otomatis:
- Buat user baru jika belum ada
- Link ke user existing jika sudah ada (tidak mengubah role)
- Redirect ke dashboard sesuai role (admin/operator/user)

## File yang Sudah Dimodifikasi

- `.env` - Tambah Firebase config
- `config/firebase.php` - Baru (config Firebase)
- `routes/app/web.php` - Tambah rute `auth/firebase`
- `app/Http/Controllers/AuthController.php` - Tambah method `handleFirebaseAuth()`
- `app/Models/User.php` - Update `$fillable` untuk provider fields
- `resources/views/pages/auth/login.blade.php` - Tambah Firebase SDK + Google button
- `resources/views/pages/auth/register.blade.php` - Tambah Firebase SDK + Google button
- `resources/views/pages/auth/forgot.blade.php` - Tambah Firebase SDK + Google button
- `database/migrations/2026_06_19_000000_add_social_columns_to_users.php` - Migration untuk provider columns

## Troubleshooting

### Error: "This domain is not authorized to run this operation"
**Solusi**: Pastikan domain Anda sudah ditambahkan di Firebase Console → Authentication → Settings → Authorized domains

### Error: "API key not valid"
**Solusi**: Pastikan `.env` values sudah benar, jalankan `php artisan config:clear`

### User tidak ter-create di database
**Solusi**: Pastikan migration sudah jalan: `php artisan migrate`

### Google popup tidak muncul
**Solusi**: 
- Check browser console (F12) untuk error
- Pastikan JavaScript tidak diblokir
- Coba di incognito mode

## Local vs Production

| Aspek | Local | Production |
|-------|-------|-----------|
| Domain | `localhost:8000` | `your-domain.com` |
| .env FIREBASE_* | Test project values | Production project values |
| URL auth callback | Otomatis (Firebase SDK) | HTTPS required |
| Database | Local MySQL | Production DB |

Tidak perlu setup OAuth credentials terpisah — Firebase menangani semuanya!
