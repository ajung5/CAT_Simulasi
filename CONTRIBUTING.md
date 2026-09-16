# Contributing

Terima kasih atas kontribusinya pada CAT Simulasi.

## Workflow

1. Clone atau fork repository.
2. Buat branch baru.
3. Lakukan perubahan yang fokus.
4. Test pada Docker environment.
5. Commit dengan pesan yang jelas.
6. Buat pull request jika menggunakan workflow kolaboratif.

Contoh branch:

```text
feature/import-validation
fix/excel-reader
docs/docker-setup
```

## Commit Convention

Gunakan prefix yang konsisten:

```text
feat:
fix:
docs:
refactor:
chore:
security:
```

Contoh:

```text
fix: improve legacy Excel reader compatibility
```

## Before Commit

```bash
git status
git diff
docker compose ps
```

Untuk file PHP:

```bash
docker compose exec web php -l /path/to/file.php
```

## Legacy Scope

Hindari upgrade framework atau dependency besar dalam satu perubahan tanpa regression testing.
