# Multi-Tenant Task SaaS

Laravel 12 SaaS app with PostgreSQL schema isolation, Blade, Tailwind, and Vite.

## Stack

- PHP 8.2+
- Laravel 12
- PostgreSQL
- Blade
- Tailwind CSS
- Vite

## Architecture

Public schema:
- `admins`
- `tenants`
- shared framework tables

Tenant schema:
- `users`
- `tasks`

Tenant switching happens in [IdentifyTenant.php](/Users/li/MyProjects/Task_laravel/app/Http/Middleware/IdentifyTenant.php) before tenant auth and task queries run.

## Features

Super admin:
- login/logout
- dashboard
- tenant list
- create tenant
- edit tenant
- activate/deactivate tenant

Tenant app:
- login/logout
- dashboard
- task CRUD
- task status
- task due date

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
```

### `.env`

```env
APP_NAME="MultiTenantSaaS"
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=task_laravel
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

## PostgreSQL

1. Create a PostgreSQL database named `task_laravel`.
2. Allow the DB user to create schemas.
3. Keep `public` as the base schema.

## Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

Seeding creates:
- `public.admins`
- `public.tenants`
- `tenant_acme`
- tenant users and sample tasks

Super admin:
- `http://127.0.0.1:8000/admin/login`
- `admin@example.com`
- `password`

## Default Credentials

Super admin:
- Email: `admin@example.com`
- Password: `password`
 

## Tenant Creation

1. Log in at `/admin/login`
2. Open `Tenants`
3. Click `Create Tenant`
4. Fill tenant name, slug, owner name, owner email, owner password, and status
5. Submit

Provisioning creates the tenant record, schema, migrations, and owner account.

## Run

```bash
composer run dev
```

Or:

```bash
php artisan serve
npm run dev
```

Build assets:

```bash
npm run build
```

## Routes

- `/admin/login`
- `/admin/dashboard`
- `/admin/tenants`
- `/tenant/{slug}`
- `/tenant/{slug}/login`
- `/tenant/{slug}/dashboard`
- `/tenant/{slug}/tasks`

 
