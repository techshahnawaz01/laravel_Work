# Quick Start Guide

Get the multi-tenant Laravel application running in 5 minutes.

## Prerequisites

- PHP 8.2+
- PostgreSQL 12+
- Composer
- Node.js & NPM

## Installation Steps

### 1. Clone and Install

```bash
git clone <repository-url>
cd Task_laravel
composer install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration

Edit `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel_tenant_db
DB_USERNAME=postgres
DB_PASSWORD=
```

### 4. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

### 5. Configure Hosts File

Add to `/etc/hosts` (Linux/Mac) or `C:\Windows\System32\drivers\etc\hosts` (Windows):

```bash
127.0.0.1  acme.test
```

### 6. Start Development Server

```bash
php artisan serve
```

## Access the Application

### Super Admin Panel
- URL: `http://127.0.0.1:8000/admin/login`
- Email: `admin@example.com`
- Password: `password`

### Tenant Portal
- URL: `http://acme.test/tenant/login`
- Email: `admin@acme.com`
- Password: `password`

## What's Next?

1. **Create a Tenant**: Login as admin and create a new tenant
2. **Initialize Tenant**: Click "Initialize" to create tenant schema
3. **Login as Tenant**: Use tenant credentials to access portal
4. **Manage Tasks**: Create, edit, view, and delete tasks
5. **Explore Features**: Check out dashboards and statistics

## Common Issues

### 500 Error on Tenant Domain
- Ensure hosts file is configured correctly
- Clear cache: `php artisan config:clear`
- Check database connection

### Schema Not Found
- Initialize tenant from admin panel
- Check PostgreSQL logs
- Verify user has schema creation privileges

### Migration Errors
- Ensure PostgreSQL extensions are enabled
- Check database credentials in `.env`
- Verify database exists

## Need Help?

- See [README.md](README.md) for detailed setup
- See [docs/testing-guide.md](docs/testing-guide.md) for testing
- See [docs/deployment-checklist.md](docs/deployment-checklist.md) for production

---

**Happy coding!** 🚀