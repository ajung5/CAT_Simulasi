# Architecture

## Local Development Architecture

```text
Browser
   │
   │ http://127.0.0.1:8000
   ▼
PHP 7.1.33 built-in server
Document root: CAT_Simulasi/
   │
   ▼
/index.php
   │
   ▼
/protected/bootstrap
   │
   ▼
Laravel 5.1.45 LTS
   │
   │ PDO MySQL
   ▼
127.0.0.1:3306
MySQL local (Homebrew)
   │
   ▼
Database: ujian
```

## Application Layout

```text
CAT_Simulasi/
├── index.php
├── .htaccess
├── assets/
├── css/
├── img/
├── js/
└── protected/
    ├── artisan
    ├── composer.json
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── storage/
    └── vendor/
```

`index.php` root memuat:

```text
protected/bootstrap/autoload.php
protected/bootstrap/app.php
```

Karena itu root repository adalah document root aplikasi.

## Kenapa `artisan serve` Tidak Digunakan

Project ini tidak menggunakan struktur `project/public/index.php`. Laravel 5.1 `artisan serve` dapat gagal dengan:

```text
chdir(): No such file or directory
```

Gunakan:

```bash
php -S 127.0.0.1:8000
```

atau dari `protected/`:

```bash
php -S 127.0.0.1:8000 -t ..
```

## Database Layer

```text
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujian
```

## Docker

`compose.yml` dan `dockerfile` tetap ada untuk compatibility testing. Native stack adalah workflow utama untuk Mac karena lebih ringan.
