# Alur Kerja Pengiriman Email OTP di Laravel

Tentu, saya sangat senang bisa membantu Anda berhasil! Memahami alur kerja kode sama pentingnya dengan membuatnya berjalan. Berikut adalah penjelasan alur pengiriman OTP di proyek Laravel Anda dari awal hingga akhir.

Proses pengiriman email OTP di aplikasi Anda melibatkan beberapa komponen utama yang bekerja sama: **Route**, **Controller**, **Mailable**, dan **View**. Laravel mengoordinasikan semuanya dengan konfigurasi dari file `.env` Anda.

---

### 1. Route (Penunjuk Jalan) - `routes/web.php`

Semuanya dimulai ketika pengguna melakukan aksi yang memicu pengiriman OTP, misalnya dengan menekan tombol "Kirim OTP". Aksi ini akan mengirim permintaan ke URL tertentu di server Anda.

- **Tugas Route**: Memberi tahu Laravel, "Jika ada permintaan yang masuk ke URL ini (misalnya, `/kirim-otp`), jalankan fungsi tertentu di Controller ini."

**Contoh di `routes/web.php`:**
```php
use App\Http\Controllers\AuthController;

// Ketika ada request POST ke /kirim-otp, panggil method 'sendOtp' di AuthController
Route::post('/kirim-otp', [AuthController::class, 'sendOtp']);
```

---

### 2. Controller (Otak Logika) - `app/Http/Controllers/AuthController.php`

Setelah Route mengarahkan permintaan, Controller mengambil alih. Di sinilah semua logika inti terjadi.

- **Tugas Controller (`sendOtp` method)**:
    1.  **Mencari User**: Menemukan data pengguna di database berdasarkan email yang diinput.
    2.  **Membuat OTP**: Menghasilkan kode acak (misalnya, `rand(100000, 999999)`).
    3.  **Menyimpan OTP**: Menyimpan kode OTP tersebut beserta waktu kedaluwarsanya ke dalam tabel `users` di database. Ini sangat penting agar nanti sistem bisa memverifikasi OTP yang dimasukkan pengguna.
    4.  **Memicu Pengiriman Email**: Memberi perintah kepada Laravel untuk mengirim email.

**Contoh kode di `AuthController.php`:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        // 1. Mencari User
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // 2. Membuat OTP
            $otp = rand(100000, 999999);

            // 3. Menyimpan OTP
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            // 4. Memicu Pengiriman Email
            Mail::to($user->email)->send(new OtpMail($otp));

            return "OTP terkirim!";
        }
        
        return "User tidak ditemukan.";
    }
}
```
Perhatikan baris `Mail::to($user->email)->send(new OtpMail($otp));`. Baris ini memerintahkan Laravel untuk mengirim email menggunakan "cetakan" email bernama `OtpMail` dan memberikan variabel `$otp` ke dalamnya.

---

### 3. Mailable (Cetakan Email) - `app/Mail/OtpMail.php`

Mailable adalah sebuah kelas PHP yang merepresentasikan satu jenis email. Anggap saja ini sebagai *blueprint* atau cetakan untuk email OTP Anda.

- **Tugas Mailable**:
    1.  **Menerima Data**: Melalui *constructor* (`__construct`), ia menerima data yang dikirim dari Controller (dalam hal ini, kode `$otp`).
    2.  **Mengatur Amplop**: Menentukan informasi dasar email seperti subjek (`Subject`).
    3.  **Menentukan Konten**: Memberi tahu Laravel file *view* mana yang harus digunakan untuk membuat isi (body) email.

**Contoh kode di `OtpMail.php`:**
```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // Properti publik agar bisa diakses di view

    /**
     * 1. Menerima data dari Controller
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * 2. Mengatur subjek email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Anda',
        );
    }

    /**
     * 3. Menentukan file view untuk isi email
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp', // Menggunakan resources/views/emails/otp.blade.php
        );
    }
}
```

---

### 4. View (Tampilan Email) - `resources/views/emails/otp.blade.php`

Ini adalah file HTML (dengan sintaks Blade Laravel) yang mendesain tampilan email yang akan diterima oleh pengguna.

- **Tugas View**: Menampilkan data yang diterima dari Mailable dalam format HTML yang rapi. Karena properti `$otp` di Mailable bersifat `public`, kita bisa langsung menggunakannya di sini.

**Contoh kode di `emails/otp.blade.php`:**
```blade
<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
</head>
<body>
    <h1>Kode OTP Anda adalah: {{ $otp }}</h1>
    <p>Gunakan kode ini untuk melanjutkan proses login.</p>
</body>
</html>
```

---

### 5. Konfigurasi Mail (`.env` dan `config/mail.php`)

Di balik layar, ketika `Mail::send()` dipanggil, Laravel melakukan ini:
1.  Membaca file `config/mail.php` untuk mengetahui pengaturan email.
2.  File `config/mail.php` mengambil nilai detailnya dari file `.env` Anda.
3.  Laravel melihat:
    -   `MAIL_MAILER=smtp` -> Oke, kita akan pakai protokol SMTP.
    -   `MAIL_HOST=smtp.gmail.com` -> Ini servernya.
    -   `MAIL_USERNAME` & `MAIL_PASSWORD` -> Ini kredensial untuk login ke server.
4.  Laravel kemudian menyusun email menggunakan Mailable dan View, lalu mengirimkannya melalui server Gmail sesuai konfigurasi `.env`.
