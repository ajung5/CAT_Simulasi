# Security Policy

## Scope

Repository ini berisi aplikasi legacy. Environment Docker yang disediakan terutama ditujukan untuk development dan compatibility testing.

## Reporting a Vulnerability

Jangan membuat public issue yang berisi:

- credential atau secret;
- token atau session;
- database dump yang mengandung data sensitif;
- exploit detail terhadap deployment aktif;
- informasi pribadi pengguna.

Laporkan vulnerability secara private kepada maintainer repository.

## Security Guidelines

- Jangan commit `.env`.
- Jangan commit credential, token, atau secret.
- Jangan gunakan credential development pada production.
- Jaga `APP_KEY` tetap rahasia.
- Batasi akses phpMyAdmin.
- Jangan expose MySQL ke internet.
- Lakukan backup sebelum perubahan database.
- Review dependency legacy sebelum production deployment.

## Legacy Dependency Warning

Laravel 5.1, PHP 7.1, MySQL 5.7, dan beberapa library project merupakan komponen legacy dan perlu mendapat perhatian khusus dari sisi keamanan.
