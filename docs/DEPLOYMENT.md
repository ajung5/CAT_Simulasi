# Deployment Notes

Konfigurasi repository saat ini terutama ditujukan untuk local development.

## Sebelum Production

- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Gunakan `APP_KEY` unik dan rahasia.
- Ganti seluruh credential development.
- Jangan expose MySQL ke internet.
- Jangan expose phpMyAdmin secara publik.
- Gunakan HTTPS.
- Terapkan backup dan log rotation.
- Review permission file/folder.
- Review dependency legacy dan vulnerability yang diketahui.

## Database

Gunakan user database dengan least privilege. Jangan menggunakan credential development seperti `root/root` atau `catuser/catpassword`.

## phpMyAdmin

Untuk production, sebaiknya tidak dipublikasikan. Jika dibutuhkan, batasi melalui VPN, reverse proxy authentication, IP allowlist, atau jaringan internal.

## Regression Test Priority

1. Authentication
2. Session
3. Bank soal
4. Import soal
5. Ujian siswa
6. Penilaian
7. Export/report
8. Database compatibility
