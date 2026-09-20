# Installation — Native macOS

Dokumen ini adalah jalur setup utama untuk menjalankan CAT Simulasi secara lokal dengan penggunaan resource rendah tanpa Docker, XAMPP, Apache, atau Nginx.

## Stack yang Digunakan

- macOS
- Homebrew
- PHP 7.1.33
- Composer 2.2 LTS
- Laravel 5.1.45 LTS
- MySQL lokal via Homebrew
- Database: `ujian`
- VS Code opsional

## 1. Clone Repository

```bash
git clone https://github.com/ajung5/CAT_Simulasi.git
cd CAT_Simulasi
```

Pastikan entry point tersedia:

```bash
ls -lah index.php
```

## 2. Install PHP 7.1

PHP default pada Mac dapat tetap menggunakan versi modern. Install PHP 7.1 berdampingan:

```bash
brew tap shivammathur/php
brew install shivammathur/php/php@7.1
```

Aktifkan PHP 7.1 hanya untuk terminal yang sedang digunakan:

```bash
export PATH="$(brew --prefix shivammathur/php/php@7.1)/bin:$(brew --prefix shivammathur/php/php@7.1)/sbin:$PATH"
php -v
```

Target:

```text
PHP 7.1.33
```

## 3. Pastikan Extension PHP

```bash
php -m | grep -Ei 'openssl|PDO|pdo_mysql|mysqlnd'
```

Minimal aplikasi membutuhkan PDO dan `pdo_mysql`.

## 4. Gunakan Composer 2.2 LTS

Composer 2.3+ tidak mendukung PHP 7.1. `composer.json` berada di `protected/`.

```bash
cd protected
```

Jika `composer22.phar` belum tersedia secara lokal:

```bash
curl -sS https://getcomposer.org/download/latest-2.2.x/composer.phar -o composer22.phar
```

Cek:

```bash
php composer22.phar --version
```

Install dependency:

```bash
php composer22.phar install
```

Jangan gunakan `composer update` untuk setup awal aplikasi legacy.

## 5. Setup MySQL

```bash
brew services start mysql
mysqladmin ping
```

Target:

```text
mysqld is alive
```

Setup database `ujian` dan import SQL dijelaskan pada [DATABASE.md](DATABASE.md).

## 6. Konfigurasi Environment

File environment berada di:

```text
protected/.env
```

Contoh:

```dotenv
APP_ENV=local
APP_DEBUG=true

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujian
DB_USERNAME=<user-database-lokal>
DB_PASSWORD=<password-database-lokal>

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

Jangan commit credential asli atau APP_KEY rahasia.

Setelah perubahan:

```bash
cd protected
php artisan config:clear
php artisan cache:clear
```

## 7. Verifikasi Laravel

```bash
php artisan --version
```

Target:

```text
Laravel Framework version 5.1.45 (LTS)
```

Tes koneksi database tanpa mengubah schema:

```bash
php artisan migrate:status
```

Jangan jalankan `migrate` atau `migrate:fresh` sebelum backup dan verifikasi schema existing.

## 8. Jalankan Aplikasi

Dari root:

```bash
cd /path/to/CAT_Simulasi
php -S 127.0.0.1:8000
```

Jika terminal berada di `protected/`:

```bash
php -S 127.0.0.1:8000 -t ..
```

Buka:

```text
http://127.0.0.1:8000
```

## Kenapa Bukan `php artisan serve`?

Layout repository:

```text
CAT_Simulasi/
├── index.php
└── protected/
    ├── artisan
    ├── composer.json
    └── ...
```

Laravel 5.1 `artisan serve` mengharapkan direktori `public/` di bawah aplikasi. Pada layout ini dapat muncul:

```text
chdir(): No such file or directory (errno 2)
```

Gunakan PHP built-in server dengan document root repository.

## Docker

File Docker tetap tersedia sebagai opsi compatibility testing, tetapi bukan jalur utama untuk local development ringan.
