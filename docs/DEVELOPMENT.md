# Development Guide

Workflow utama development CAT Simulasi di macOS menggunakan PHP dan MySQL native agar ringan dan tidak membutuhkan Docker Desktop.

## Start Session Development

```bash
cd /path/to/CAT_Simulasi

export PATH="$(brew --prefix shivammathur/php/php@7.1)/bin:$(brew --prefix shivammathur/php/php@7.1)/sbin:$PATH"

php -v
brew services start mysql
php -S 127.0.0.1:8000
```

Akses:

```text
http://127.0.0.1:8000
```

Jika berada di `protected/`:

```bash
php -S 127.0.0.1:8000 -t ..
```

Jangan gunakan `php artisan serve` pada layout repository ini.

## Artisan

```bash
cd protected
php artisan --version
php artisan config:clear
php artisan cache:clear
php artisan migrate:status
```

## Composer

```bash
cd protected
php composer22.phar install
```

Pastikan `php -v` menunjukkan PHP 7.1.33 sebelum Composer dijalankan karena Composer scripts memanggil `php artisan`.

Hindari `composer update` kecuali upgrade dependency memang disengaja dan sudah diuji.

## Stop Local Server

Tekan `Ctrl+C`.

MySQL dapat dihentikan:

```bash
brew services stop mysql
```

## Regression Test Minimum

1. Authentication
2. Session
3. Bank soal
4. Import soal
5. Pelaksanaan ujian
6. Penilaian
7. Export/report
8. Koneksi database
