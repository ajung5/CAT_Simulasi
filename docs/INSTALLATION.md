# Installation

## Requirements

- Git
- Docker Desktop / Docker Engine
- Docker Compose v2

```bash
docker --version
docker compose version
```

## Clone

```bash
git clone https://github.com/ajung5/CAT_Simulasi.git
cd CAT_Simulasi
```

## Environment

```bash
cp protected/.env.example protected/.env
```

Contoh:

```dotenv
APP_ENV=local
APP_DEBUG=true
APP_KEY=<32-character-key>

DB_HOST=db
DB_DATABASE=ujian
DB_USERNAME=catuser
DB_PASSWORD=catpassword

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

Generate key:

```bash
openssl rand -hex 16
```

## Dockerfile Case Sensitivity

Jika file masih bernama `dockerfile` sedangkan `compose.yml` mereferensikan `Dockerfile`:

```bash
mv dockerfile Dockerfile
```

Hal ini penting pada Linux yang case-sensitive.

## Start

```bash
docker compose up -d --build
docker compose ps
```

Akses:

```text
Application : http://localhost:8080
phpMyAdmin  : http://localhost:8081
```

## Apple Silicon

Stack menggunakan `linux/amd64` untuk kompatibilitas dependency legacy. Warning `amd64` vs `arm64` dapat muncul pada Mac Apple Silicon; selama container running/healthy, warning tersebut bukan kegagalan.
