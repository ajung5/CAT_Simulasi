# CAT Simulasi

CAT Simulasi adalah aplikasi **Computer Assisted Test (CAT)** / ujian berbasis komputer berbasis **Laravel 5.1**.

Project menggunakan Docker untuk menjaga kompatibilitas stack legacy tanpa mengganggu environment PHP modern pada host.

## Features

- Portal Guru / Administrator
- Portal Siswa
- Manajemen bank soal
- Import soal dari Excel
- Manajemen peserta ujian
- Pelaksanaan ujian berbasis web
- Penilaian hasil ujian
- Pengelolaan data sekolah

## Tech Stack

- Laravel 5.1
- PHP 7.1 + Apache
- MySQL 5.7
- phpMyAdmin
- Docker Compose

## Quick Start

```bash
git clone https://github.com/ajung5/CAT_Simulasi.git
cd CAT_Simulasi
cp protected/.env.example protected/.env
docker compose up -d --build
```

| Service | URL |
|---|---|
| CAT Simulasi | `http://localhost:8080` |
| phpMyAdmin | `http://localhost:8081` |

> Pastikan `protected/.env` menggunakan `DB_HOST=db`.

## Documentation

- [Installation](docs/INSTALLATION.md)
- [Database](docs/DATABASE.md)
- [Import Soal](docs/IMPORT-SOAL.md)
- [Development](docs/DEVELOPMENT.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Deployment Notes](docs/DEPLOYMENT.md)
- [Troubleshooting](docs/TROUBLESHOOTING.md)

Repository docs:
- [Security Policy](SECURITY.md)
- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
- [License](LICENSE)

## Project Structure

```text
CAT_Simulasi/
├── assets/
├── css/
├── img/
├── js/
├── protected/
├── docs/
├── Dockerfile
├── compose.yml
├── index.php
└── ujian.sql
```

## Legacy Notice

Project menggunakan framework dan dependency lama. Upgrade major version sebaiknya dilakukan bertahap dengan regression testing.

## Security

Konfigurasi Docker ditujukan terutama untuk **local development**. Jangan gunakan credential development default pada production.

## Repository

https://github.com/ajung5/CAT_Simulasi
