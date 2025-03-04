## Simple Rest API CRUD - Perpustakaan
Merupakan sebuah aplikasi mini berbasis REST API yang digunakan untuk mengelola data perpustakaan. API ini memungkinkan untuk dilakukannya operasi CRUD (Create, Read, Update, Delete) pada data buku, dan peminjaman buku. API ini dikembangkan menggunakan framework Laravel dan menggunakan database MySQL.

### Fitur
- Mengelola data buku
- Mengelola data pengguna
- Mengelola data buku yang dipinjam
- Mengelola data pengembalian buku

### Teknologi yang digunakan
- Laravel 11
- MySQL
- PHP^8.2
- Composer

### Database
Database yang digunakan adalah MySQL dengan nama database **crud_perpustakaan**.

### Setup
1. Buat database dengan nama crud_perpustakaan
2. buka cmd ketikkan `php artisan migrate`
3. buka cmd ketikkan `php artisan db:seed`
4. Setting API_KEY dan API_SECRET pada .env anda
