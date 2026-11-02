<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🗳️ PILKADES DIGITAL

## 🌻 Deskripsi

Pilkades Digital adalah aplikasi simulasi pemilihan kepala desa berbasis web. Panitia mendaftarkan kandidat dan pemilih, sistem menerbitkan QR Code hak pilih untuk setiap pemilih, petugas memindai QR Code dengan kamera, lalu pemilih memberikan satu suara pada halaman pemilihan. Hasil pemilihan dapat dipantau panitia melalui dashboard.

Aplikasi ini dibuat sebagai simulasi. Sebelum dipakai pada pemilihan sungguhan, rancangan keamanan, kerahasiaan suara, dan kepatuhan terhadap peraturan yang berlaku harus ditinjau dan diaudit oleh pihak yang berwenang.

## ✨ Fitur

-   **Dashboard panitia**: ringkasan pemilih, kandidat, dan partisipasi.
-   **Manajemen kandidat**: nomor urut, foto, profil, visi, dan misi.
-   **Manajemen pemilih**: tambah pemilih secara manual, data ganda ditolak.
-   **Pemilihan otomatis**: mengetik nama pemilihan baru pada form kandidat atau pemilih akan membuatnya otomatis, lalu muncul sebagai saran berikutnya.
-   **QR Code hak pilih**: satu QR Code unik untuk setiap pemilih, hanya berlaku satu kali.
-   **Pemindaian QR Code**: memakai kamera perangkat, dengan tombol putar kamera depan/belakang dan input kode manual sebagai cadangan.
-   **Halaman pemilihan**: pemilih hanya dapat memilih satu kandidat.
-   **Hasil pemilihan**: rekapitulasi suara per kandidat.

## 🔒 Aturan Pemilihan

-   Satu pemilih hanya dapat memberikan satu suara untuk satu kandidat.
-   Permintaan yang memuat lebih dari satu kandidat ditolak seluruhnya oleh server.
-   QR Code yang sudah dipakai tidak dapat dipakai lagi.
-   Validasi dilakukan di backend, bukan hanya di tampilan.

## ⚡ Teknologi

-   [PHP 8.2+](https://php.net/) : Bahasa Pemrograman
-   [Laravel](https://laravel.com/) : Framework
-   [Livewire](https://livewire.laravel.com/) : Komponen interaktif
-   [Alpine.js](https://alpinejs.dev/) : Interaksi ringan di sisi browser
-   [Tailwind CSS](https://tailwindcss.com/) : Styling
-   [Vite](https://vitejs.dev/) : Build aset frontend
-   [html5-qrcode](https://github.com/mebjas/html5-qrcode) : Pemindai QR Code lewat kamera
-   [MySQL](https://www.mysql.com/) : Database

## 🚩 Cara Menjalankan

1. Clone repository ini dengan perintah

```git
git clone https://github.com/<username>/pilkades-app.git
```

2. Masuk ke direktori aplikasi dengan perintah

```
cd pilkades-app
```

3. Install dependency

```
composer install
npm install
```

4. Salin file .env.example menjadi .env dengan perintah

```
cp .env.example .env
```

5. Buat database MySQL kosong, lalu sesuaikan konfigurasi aplikasi dan database pada file .env

```
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evoting
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan perintah

```
php artisan key:generate
php artisan storage:link
```

7. Run Migration & Database Seeder

```
php artisan migrate --seed
```

8. Jalankan Vite (untuk pengembangan)

```
npm run dev
```

9. Jalankan php local development server

```
php artisan serve
```

10. Aplikasi dapat diakses melalui http://localhost:8000

## 🧪 Alur Simulasi

1. Login sebagai panitia.
2. Tambahkan kandidat. Ketik nama pemilihan pada form, dan pemilihan baru dibuat otomatis jika belum ada.
3. Tambahkan pemilih. QR Code hak pilih dibuat setelah data disimpan.
4. Cetak atau tampilkan QR Code pemilih.
5. Buka halaman **Scan QR**, lalu arahkan kamera ke QR Code.
6. Pilih satu kandidat dan konfirmasi pilihan.
7. Lihat hasil pemilihan pada halaman **Hasil**.


## 👨‍💻 Kontributor

-   M. Fahri Salam (Developer)
