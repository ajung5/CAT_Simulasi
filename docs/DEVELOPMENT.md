# Development Guide

## Start Environment

```bash
docker compose up -d
docker compose ps
```

Project directory di-mount ke container, sehingga perubahan PHP, Blade, CSS, dan JavaScript umumnya langsung terlihat tanpa rebuild.

## Kapan Rebuild?

Rebuild diperlukan jika mengubah:

- Dockerfile
- PHP extension
- base image
- konfigurasi build

```bash
docker compose build --no-cache web
docker compose up -d
```

## Artisan

```bash
docker compose exec web php /var/www/html/protected/artisan
```

Contoh:

```bash
docker compose exec web php /var/www/html/protected/artisan config:clear
```

## PHP Syntax Check

```bash
docker compose exec web php -l /var/www/html/protected/app/Http/Controllers/GuruController.php
```

## Git

```bash
git status
git diff
```

Commit prefix yang disarankan:

```text
feat:
fix:
docs:
refactor:
chore:
security:
```
