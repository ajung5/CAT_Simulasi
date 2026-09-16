# Database

CAT Simulasi menggunakan MySQL 5.7.

## Development Configuration

```dotenv
DB_HOST=db
DB_DATABASE=ujian
DB_USERNAME=catuser
DB_PASSWORD=catpassword
```

Gunakan `db`, bukan `localhost`, karena MySQL berjalan pada container terpisah.

## phpMyAdmin

```text
URL      : http://localhost:8081
Server   : db
Username : catuser
Password : catpassword
Database : ujian
```

## MySQL CLI

```bash
docker compose exec db mysql -ucatuser -pcatpassword ujian
```

## Backup

```bash
docker compose exec db mysqldump -uroot -proot ujian > backup_ujian.sql
```

## Restore

```bash
docker compose exec -T db mysql -uroot -proot ujian < backup_ujian.sql
```

## Reset Development Database

```bash
docker compose down -v
docker compose up -d
```

> Perintah `down -v` menghapus seluruh isi Docker volume database.
