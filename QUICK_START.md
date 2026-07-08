# Quick Start

## Requirements

- PHP 8.2+
- PostgreSQL 12+
- Composer
- Node.js and npm

## Steps

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Then run the frontend:

```bash
npm install
npm run dev
```

## Optional Host Setup

For local tenant-style URLs, add a host entry:

```bash
127.0.0.1  acme.test
```

## URLs

Super admin:
- `http://127.0.0.1:8000/admin/login`
- `admin@example.com`
- `password`

## If Something Fails

- Clear config cache: `php artisan config:clear`
- Check PostgreSQL connectivity
- Confirm the tenant schema exists
- Re-run: `php artisan migrate:fresh --seed`

## Next Steps

1. Log in as admin.
2. Create a tenant.
3. Open the tenant login URL.
4. Manage tasks.

