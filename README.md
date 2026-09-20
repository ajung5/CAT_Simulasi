# CAT Simulasi

CAT Simulasi adalah aplikasi **Computer Assisted Test (CAT)** / ujian berbasis komputer yang menggunakan stack legacy Laravel.

## Status Stack Lokal

Setup lokal yang telah diverifikasi pada macOS:

- Laravel Framework **5.1.45 (LTS)**
- PHP **7.1.33**
- Composer **2.2 LTS**
- MySQL melalui Homebrew
- Database aplikasi: `ujian`
- Entry point web: `/index.php`
- Source Laravel: `/protected`
- Local web server: PHP built-in server
- Docker/XAMPP/Apache **tidak diperlukan** untuk workflow lokal ringan

> Project ini menggunakan layout Laravel lama/custom. `index.php` berada di root repository, bukan di `protected/public`. Karena itu `php artisan serve` bukan cara menjalankan aplikasi ini.

## Features

- Portal Guru / Administrator
- Portal Siswa
- Manajemen bank soal
- Import soal dari Excel
- Manajemen peserta ujian
- Pelaksanaan ujian berbasis web
- Penilaian hasil ujian
- Pengelolaan data sekolah

## Quick Start macOS

```bash
git clone https://github.com/ajung5/CAT_Simulasi.git
cd CAT_Simulasi
```

Aktifkan PHP 7.1 untuk terminal saat ini:

```bash
export PATH="$(brew --prefix shivammathur/php/php@7.1)/bin:$(brew --prefix shivammathur/php/php@7.1)/sbin:$PATH"
php -v
```

Target:

```text
PHP 7.1.33
```

Install dependency dari folder `protected` menggunakan Composer 2.2:

```bash
cd protected
php composer22.phar install
cd ..
```

Pastikan MySQL berjalan:

```bash
brew services start mysql
mysqladmin ping
```

Database aplikasi bernama `ujian`. Lihat [Database Guide](docs/DATABASE.md) untuk pembuatan database, import `ujian.sql`, dan catatan kompatibilitas autentikasi MySQL.

Jalankan aplikasi dari root repository:

```bash
php -S 127.0.0.1:8000
```

Atau jika terminal sedang berada di `protected/`:

```bash
php -S 127.0.0.1:8000 -t ..
```

Buka:

```text
http://127.0.0.1:8000
```

## Documentation

- [Installation](docs/INSTALLATION.md)
- [Database](docs/DATABASE.md)
- [Development](docs/DEVELOPMENT.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Troubleshooting](docs/TROUBLESHOOTING.md)
- [Import Soal](docs/IMPORT-SOAL.md)
- [Deployment Notes](docs/DEPLOYMENT.md)

Repository docs:

- [Security Policy](SECURITY.md)
- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
- [License](LICENSE)

## Project Structure

```text
CAT_Simulasi/
├── index.php                 # web entry point
├── .htaccess
├── assets/
├── css/
├── img/
├── js/
├── BankSoal/
├── protected/
│   ├── artisan
│   ├── composer.json
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   └── vendor/
├── docs/
├── ujian.sql
├── compose.yml               # optional/legacy container workflow
└── dockerfile                # optional/legacy container workflow
```

## Important Compatibility Notes

Project ini menggunakan dependency legacy. PHP modern seperti PHP 8.x tidak direkomendasikan untuk menjalankan source saat ini tanpa proses upgrade dan regression testing.

MySQL modern dapat menggunakan metode autentikasi yang tidak dipahami oleh PDO/mysqlnd pada PHP 7.1. Jika muncul error `SQLSTATE[HY000] [2054]` terkait `caching_sha2_password`, lihat [Troubleshooting](docs/TROUBLESHOOTING.md).

## Security

Repository ini ditujukan terutama untuk development/local testing. Jangan gunakan credential lokal pada production, jangan expose MySQL ke internet, dan jangan commit file `.env` yang berisi secret.
