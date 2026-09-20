# Documentation

Dokumentasi CAT Simulasi menggunakan **native local development** sebagai jalur utama karena lebih ringan untuk macOS dan tidak membutuhkan Docker Desktop.

| Document | Description |
|---|---|
| [INSTALLATION.md](INSTALLATION.md) | Setup macOS: PHP 7.1, Composer 2.2, MySQL, local server |
| [DATABASE.md](DATABASE.md) | Database `ujian`, import SQL, backup/restore, kompatibilitas MySQL |
| [DEVELOPMENT.md](DEVELOPMENT.md) | Workflow development dari VS Code/Terminal |
| [ARCHITECTURE.md](ARCHITECTURE.md) | Struktur custom Laravel dan alur request |
| [TROUBLESHOOTING.md](TROUBLESHOOTING.md) | Composer, PHP, Artisan, MySQL auth, routing |
| [IMPORT-SOAL.md](IMPORT-SOAL.md) | Format dan prosedur import soal |
| [DEPLOYMENT.md](DEPLOYMENT.md) | Catatan deployment dan hardening |

## Current Verified Local Stack

```text
Laravel  : 5.1.45 LTS
PHP      : 7.1.33
Composer : 2.2 LTS
Database : ujian
Web root : repository root
Entry    : /index.php
App      : /protected
URL      : http://127.0.0.1:8000
```

Docker masih tersedia sebagai opsi compatibility testing, tetapi bukan workflow utama dokumentasi saat ini.
