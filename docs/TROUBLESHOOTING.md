# Troubleshooting

## `No supported encrypter found`

Pastikan `APP_KEY` memiliki panjang 32 karakter.

```bash
openssl rand -hex 16
```

Setelah mengubah `.env`:

```bash
docker compose exec web rm -f /var/www/html/protected/bootstrap/cache/config.php
docker compose restart web
```

## Database Connection Failed

Pastikan:

```dotenv
DB_HOST=db
```

bukan `localhost`.

## `mysqli` Not Available

```bash
docker compose exec web php -m | grep -Ei 'mysqli|pdo_mysql'
```

Jika belum tersedia:

```bash
docker compose build --no-cache web
docker compose up -d
```

## `OLERead has a deprecated constructor`

Di `protected/app/functions/excel_reader2.php`, ubah constructor lama menjadi `__construct()` pada class `OLERead` dan `Spreadsheet_Excel_Reader`.

Cek syntax:

```bash
docker compose exec web php -l /var/www/html/protected/app/functions/excel_reader2.php
```

## Permission Error

```bash
docker compose exec web sh -lc 'chmod -R 775 /var/www/html/protected/storage /var/www/html/protected/bootstrap/cache'
```

## Logs

```bash
docker compose logs web --tail=100
docker compose logs db --tail=100
docker compose logs phpmyadmin --tail=100
```

## Restart

```bash
docker compose restart
```
