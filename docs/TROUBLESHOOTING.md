# Troubleshooting

## PHP Default Kembali ke PHP 8.x

```bash
php -v
```

Aktifkan PHP 7.1:

```bash
export PATH="$(brew --prefix shivammathur/php/php@7.1)/bin:$(brew --prefix shivammathur/php/php@7.1)/sbin:$PATH"
which php
php -v
```

## Composer 2.3 Tidak Mendukung PHP 7.1

Error:

```text
Composer 2.3.0 dropped support for PHP <7.2.5
```

Gunakan Composer 2.2 LTS:

```bash
cd protected
curl -sS https://getcomposer.org/download/latest-2.2.x/composer.phar -o composer22.phar
php composer22.phar install
```

## Composer Tidak Menemukan composer.json

`composer.json` berada di:

```text
CAT_Simulasi/protected/composer.json
```

Jalankan Composer dari `protected/`.

## Composer Gagal pada `php artisan clear-compiled`

Pastikan PHP aktif adalah PHP 7.1:

```bash
export PATH="$(brew --prefix shivammathur/php/php@7.1)/bin:$(brew --prefix shivammathur/php/php@7.1)/sbin:$PATH"
php -v
cd protected
php composer22.phar install
```

Diagnosis tanpa scripts:

```bash
php composer22.phar install --no-scripts
```

## `php artisan serve` Menghasilkan `chdir()`

Error:

```text
[ErrorException]
chdir(): No such file or directory (errno 2)
```

Solusi dari root:

```bash
php -S 127.0.0.1:8000
```

atau dari `protected/`:

```bash
php -S 127.0.0.1:8000 -t ..
```

## PDO Error 2054 / `caching_sha2_password`

Error:

```text
SQLSTATE[HY000] [2054]
The server requested authentication method unknown to the client
[caching_sha2_password]
```

Ini merupakan compatibility issue PHP 7.1 PDO/mysqlnd dengan authentication MySQL modern.

- jangan ubah root hanya untuk aplikasi;
- gunakan user aplikasi khusus;
- gunakan database/authentication method yang kompatibel dengan PHP 7.1;
- backup database sebelum mengganti versi MySQL.

## Database Connection Refused

```bash
brew services list | grep mysql
mysqladmin ping
```

Pastikan:

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujian
```

## Route 404 pada PHP Built-in Server

PHP built-in server tidak memproses `.htaccess` seperti Apache. Jika root dapat dibuka tetapi clean URL tertentu 404:

```bash
cd protected
php artisan route:list
```

Jika aplikasi bergantung pada Apache rewrite, gunakan web server yang mendukung rewrite atau router script lokal.
