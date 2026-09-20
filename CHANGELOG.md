# Changelog

## [Unreleased]

### Added

- Native macOS local-development documentation.
- PHP 7.1.33 session-based PATH workflow.
- Composer 2.2 LTS workflow.
- Database `ujian` import/backup/restore documentation.
- Troubleshooting Composer, `artisan serve`, dan MySQL authentication.
- Dokumentasi arsitektur custom dengan `index.php` pada repository root.

### Changed

- Native PHP + MySQL menjadi workflow utama local development ringan.
- Docker menjadi opsi compatibility testing.
- Local server dijalankan dengan PHP built-in server dari repository root.
- Database connection menggunakan `127.0.0.1:3306`.
- Security guidance untuk `.env` dan credential diperkuat.

### Known Issues

- PHP 7.1 PDO/mysqlnd dapat gagal terhadap MySQL modern dengan `caching_sha2_password` (SQLSTATE 2054).
- PHP built-in server tidak memproses `.htaccess` seperti Apache.
