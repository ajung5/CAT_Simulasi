# Database

Database aplikasi CAT Simulasi bernama `ujian`.

## Start dan Cek MySQL

```bash
brew services start mysql
brew services list | grep mysql
mysqladmin ping
```

Cek versi:

```bash
mysql --version
```

atau:

```sql
SELECT VERSION();
```

## Buat Database

```bash
mysql -u root -p
```

```sql
CREATE DATABASE IF NOT EXISTS ujian
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

## Import Database Existing

Dari root repository:

```bash
mysql -u root -p ujian < ujian.sql
```

Verifikasi:

```bash
mysql -u root -p ujian
```

```sql
SHOW TABLES;
```

Untuk aplikasi existing, prioritaskan restore database existing. Jangan langsung menjalankan `php artisan migrate`.

## Konfigurasi Laravel

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujian
DB_USERNAME=<user-database-lokal>
DB_PASSWORD=<password-database-lokal>
```

Gunakan `127.0.0.1` agar koneksi menggunakan TCP.

Setelah perubahan:

```bash
cd protected
php artisan config:clear
php artisan migrate:status
```

## Kompatibilitas MySQL Modern

Pada setup yang diuji, MySQL lokal melaporkan versi `26.7.0` dan account bawaan menggunakan `caching_sha2_password`.

PHP 7.1.33 / PDO MySQL lama dapat menghasilkan:

```text
SQLSTATE[HY000] [2054]
The server requested authentication method unknown to the client
[caching_sha2_password]
```

Ini adalah compatibility issue client authentication.

Prinsip penanganan:

- jangan melemahkan account `root`;
- gunakan account database khusus aplikasi;
- gunakan server/authentication method yang benar-benar didukung PHP 7.1 PDO;
- backup database sebelum mengganti versi MySQL;
- jangan expose database legacy ke internet.

## Backup

```bash
mysqldump -u root -p ujian > backup_ujian.sql
```

## Restore

```bash
mysql -u root -p ujian < backup_ujian.sql
```

## GUI Database

Sequel Ace dapat digunakan sebagai GUI client:

```text
Host     : 127.0.0.1
Port     : 3306
Database : ujian
Username : user database lokal
```
