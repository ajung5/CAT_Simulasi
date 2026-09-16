# Architecture

## Overview

```text
Browser
   │
   ├── localhost:8080
   │        ▼
   │   PHP 7.1 + Apache
   │   Laravel 5.1
   │        │
   │        ▼
   │      db:3306
   │      MySQL 5.7
   │
   └── localhost:8081
            ▼
        phpMyAdmin
            │
            ▼
          MySQL
```

## Services

### `web`
Menjalankan Apache, PHP 7.1, Laravel 5.1, `mod_rewrite`, `pdo_mysql`, `mysqli`, dan `mbstring`.

### `db`
Menjalankan MySQL 5.7 dan database `ujian`.

### `phpmyadmin`
Interface administrasi database untuk development.

## Application Layout

Entry point:

```text
/index.php
```

Laravel application:

```text
/protected
```

Root Apache tetap mengarah ke root project karena struktur aplikasi berbeda dengan layout Laravel modern.

## Legacy Components

Sebagian kode masih menggunakan `mysqli` langsung dan legacy Excel Reader. Upgrade PHP/framework harus dilakukan bertahap.
