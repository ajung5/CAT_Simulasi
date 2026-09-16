# Import Soal

Fitur upload soal menggunakan legacy Excel Reader.

## Format

Gunakan:

```text
Excel 97-2003 Workbook (*.xls)
```

Hindari `.xlsx` karena reader lama menggunakan format BIFF/OLE.

## Struktur Kolom

| Kolom | Field |
|---|---|
| A | ID Soal |
| B | Soal |
| C | Pilihan A |
| D | Pilihan B |
| E | Pilihan C |
| F | Pilihan D |
| G | Pilihan E |
| H | Kunci Jawaban |
| I | Score |

Baris pertama adalah header; data mulai dibaca dari baris kedua.

## Checklist

- ID soal tidak kosong.
- Pilihan jawaban berada pada kolom yang benar.
- Kunci jawaban mengikuti format aplikasi.
- Score berisi nilai numerik.
- File disimpan sebagai `.xls`.
- Hindari merged cell pada area data.

## Legacy Compatibility

Pada PHP 7.1, constructor lama di `excel_reader2.php` perlu menggunakan `__construct()` agar tidak dihentikan Laravel sebagai deprecated error.
