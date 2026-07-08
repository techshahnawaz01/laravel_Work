# Deployment Checklist

## Before Deploy

- PHP 8.2+
- PostgreSQL 12+
- Composer and Node installed
- SSL ready
- Web server configured

## Build

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate
```

## Database

- Create production database
- Set strong DB credentials
- Run migrations
- Run seeders only if needed for initial setup

## Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

## Post-Deploy

- Admin login works
- Tenant login works
- Tenant dashboard loads
- Task CRUD works
- No debug mode
- HTTPS enabled

