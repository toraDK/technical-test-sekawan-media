# FleetCore - Vehicle Management System

FleetCore adalah aplikasi manajemen kendaraan operasional dengan fitur pemesanan kendaraan, approval berjenjang, dashboard ringkasan, dan export data booking ke Excel.

## Informasi Teknis

- Framework: Laravel 12
- PHP Version: 8.2+ (sesuai requirement proyek: `^8.2`)
- Database: MySQL 8.0+ (direkomendasikan)
- Library tambahan: `maatwebsite/excel` untuk export data

## Akun Login Default (Seeder)

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role | Username (Email) | Password |
| --- | --- | --- |
| Admin | admin@email.com | password123 |
| Approver Level 1 | atasan1@nikel.co.id | password123 |
| Approver Level 2 | atasan2@nikel.co.id | password123 |

## Panduan Instalasi

1. Clone repository.
2. Masuk ke folder project.
3. Install dependency backend:

```bash
composer install
```

4. Buat file environment dan generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

5. Atur koneksi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleetcore
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

7. Jalankan aplikasi:

```bash
php artisan serve
```

8. Buka aplikasi di browser:

```text
http://127.0.0.1:8000
```

## Panduan Penggunaan Aplikasi

1. Login menggunakan salah satu akun default pada tabel di atas.
2. Buka Dashboard untuk melihat ringkasan data booking dan grafik pemakaian kendaraan.
3. Menu Pemesanan:
	- Admin membuat pemesanan baru.
	- Lihat daftar seluruh booking beserta status approval level 1 dan level 2.
	- Export data pemesanan ke Excel.
4. Menu Persetujuan:
	- Approver memproses pengajuan booking (Approve/Tolak).
	- Isi catatan jika diperlukan sebelum submit keputusan.
5. Logout saat selesai menggunakan aplikasi.

## Alur Singkat Approval

1. Admin membuat booking.
2. Approver Level 1 melakukan review.
3. Approver Level 2 melakukan review lanjutan.
4. Jika seluruh level menyetujui, status booking menjadi approved.

## Perintah Berguna

```bash
php artisan migrate:fresh --seed
php artisan route:list
php artisan test
```

