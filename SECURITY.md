# Security Policy

## Scope

Repository ini berisi aplikasi legacy Laravel 5.1 / PHP 7.1 untuk local development dan compatibility testing.

## Security Guidelines

- Jangan commit `protected/.env`.
- Jangan commit credential, token, password, atau secret.
- Jangan gunakan credential development pada production.
- Jaga `APP_KEY` tetap rahasia.
- Jangan expose MySQL ke internet.
- Gunakan account database khusus aplikasi dan least privilege.
- Lakukan backup sebelum perubahan database.
- Jangan gunakan PHP built-in development server sebagai production server.

## Jika `.env` Pernah Ter-commit

Menghapus file pada commit baru tidak menghapus secret dari Git history.

Lakukan:

1. hapus file dari tracking Git;
2. tambahkan `.env` ke `.gitignore`;
3. rotate password/token/APP_KEY yang pernah terekspos;
4. bila perlu bersihkan history dengan prosedur terkontrol;
5. verifikasi credential lama sudah tidak valid.

## Legacy Dependency Warning

Laravel 5.1, PHP 7.1, dan sebagian library telah melewati masa dukungan normal. Batasi stack ini untuk local/internal testing dan migrasikan bertahap ke stack yang masih didukung.

## MySQL Compatibility

PHP 7.1 PDO/mysqlnd dapat tidak kompatibel dengan authentication plugin MySQL modern seperti `caching_sha2_password`. Jangan melemahkan account administrator untuk mengatasinya.
