# Laravel Multi-Tenant Application

A production-ready multi-tenant application built with Laravel 12, featuring complete tenant isolation using PostgreSQL schemas, role-based authentication, and comprehensive task management.

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Installation](#installation)
- [PostgreSQL Setup](#postgresql-setup)
- [Schema Configuration](#schema-configuration)
- [Running Migrations](#running-migrations)
- [Seeders](#seeders)
- [Folder Structure](#folder-structure)
- [Screenshots](#screenshots)
- [Testing](#testing)
- [License](#license)

## 🎯 Project Overview

This application provides a complete multi-tenant SaaS platform with:

- **Super Admin Panel**: Manage tenants, monitor system
- **Tenant Portals**: Isolated workspaces for each organization
- **Task Management**: Full CRUD operations per tenant
- **Schema Isolation**: PostgreSQL schema-based data separation
- **Role-Based Access**: Separate authentication for admins and tenants

### Key Capabilities

✅ Complete tenant data isolation at database level
✅ Automatic schema switching per request
✅ Role-based authentication (Admin/Tenant)
✅ Task management with status tracking
✅ Responsive UI with Tailwind CSS
✅ Form validation and error handling
✅ Flash notifications
✅ Production-ready architecture

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12
- **Language**: PHP 8.2+
- **Database**: PostgreSQL 12+
- **Authentication**: Laravel Guards (Admin + Web)
- **Multi-Tenancy**: PostgreSQL Schema-based

### Frontend
- **CSS Framework**: Tailwind CSS (CDN)
- **Icons**: SVG Icons
- **JavaScript**: Vanilla JS
- **Design**: Responsive, Mobile-first

### Development Tools
- **Version Control**: Git
- **Package Manager**: Composer
- **Task Runner**: NPM
- **Testing**: PHPUnit

## ✨ Features

### Super Admin Features
- Dashboard with system statistics
- Create and manage tenants
- Activate/deactivate tenants
- Initialize tenant databases
- Monitor all tenants

### Tenant Features
- Dedicated portal per tenant
- User registration and authentication
- Personal dashboard with task statistics
- Full task management (CRUD)
- Task status tracking (Pending, In Progress, Completed)
- Due date management

### Technical Features
- Multi-tenant architecture with schema isolation
- Automatic schema switching via middleware
- Form validation with custom messages
- 404/403 error pages
- Flash message notifications
- Responsive design (mobile/tablet/desktop)
- CSRF protection
- SQL injection prevention
- XSS protection via Blade escaping

## 🚀 Installation

### Prerequisites

- PHP 8.2 or higher
- PostgreSQL 12 or higher
- Composer
- Node.js & NPM
- Web server (Apache/Nginx) or Laravel Valet

### Step 1: Clone Repository

```bash
git clone <repository-url>
cd Task_laravel
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (optional, for asset compilation)
npm install
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🐘 PostgreSQL Setup

### Create Database

```sql
-- Connect to PostgreSQL as superuser
psql -U postgres

-- Create database
CREATE DATABASE laravel_tenant_db;

-- Create user (optional)
CREATE USER laravel_user WITH PASSWORD 'password';

-- Grant privileges
GRANT ALL PRIVILEGES ON DATABASE laravel_tenant_db TO laravel_user;

-- Connect to database
\c laravel_tenant_db

-- Grant schema privileges
GRANT ALL ON SCHEMA public TO laravel_user;
GRANT ALL ON SCHEMA public TO PUBLIC;
```

### Enable Required Extensions

```sql
-- In PostgreSQL, ensure these extensions are available
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
CREATE EXTENSION IF NOT EXISTS "plpgsql";
```

## ⚙️ Schema Configuration

### Multi-Tenancy Setup

The application uses PostgreSQL schemas for tenant isolation:

- **Public Schema**: Contains shared tables (tenants, admins)
- **Tenant Schemas**: Each tenant gets dedicated schema (e.g., `tenant_acme`)

### Configure Tenant Settings

Edit `config/tenant.php`:

```php
return [
    'admin_prefix' => 'admin',
    'default_schema' => 'public',
    'tenant_model' => App\Models\Tenant::class,
];
```

### Host Configuration

Add tenant domains to your hosts file:

```bash
# /etc/hosts (Linux/Mac) or C:\Windows\System32\drivers\etc\hosts (Windows)
127.0.0.1  acme.test
127.0.0.1  tenant-b.test
127.0.0.1  tenant-c.test
```

## 🗄️ Running Migrations

### Step 1: Run All Migrations

```bash
php artisan migrate:fresh
```

This creates:
- `tenants` table (public schema)
- `admins` table (public schema)
- Migration tracking tables

### Step 2: Verify Migrations

```bash
# Check migration status
php artisan migrate:status

# View tables
php artisan db:show
```

### Step 3: Tenant Migrations

Tenant migrations run automatically when a tenant is initialized:

```bash
# Via admin panel
1. Login as admin
2. Create tenant
3. Click "Initialize Tenant"

# Or via artisan command (if implemented)
php artisan tenant:migrate {tenant-id}
```

## 🌱 Seeders

### Run All Seeders

```bash
php artisan migrate:fresh --seed
```

### Run Individual Seeders

```bash
# Seed admin user
php artisan db:seed --class=AdminSeeder

# Seed sample tenant
php artisan db:seed --class=TenantSeeder

# Seed sample tasks
php artisan db:seed --class=TaskSeeder
```

### Default Credentials

#### Super Admin
- **URL**: `http://127.0.0.1:8000/admin/login`
- **Email**: `admin@example.com`
- **Password**: `password`

#### Sample Tenant (Acme Corporation)
- **Domain**: `acme.test`
- **URL**: `http://acme.test/tenant/login`
- **Admin Email**: `admin@acme.com`
- **Admin Password**: `password`
- **Users**:
  - John Doe: `john@acme.com` / `password`
  - Jane Smith: `jane@acme.com` / `password`
  - Bob Johnson: `bob@acme.com` / `password`

## 📁 Folder Structure

```
Task_laravel/
├── app/
│   ├── Actions/
│   ├── Contracts/
│   ├── DTO/
│   ├── Enums/
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── TenantController.php
│   │   │   ├── Auth/
│   │   │   │   └── AdminAuthController.php
│   │   │   └── Tenant/
│   │   │       ├── AuthController.php
│   │   │       ├── DashboardController.php
│   │   │       └── TaskController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── IdentifyTenant.php
│   │       └── TenantAuthMiddleware.php
│   ├── Models/
│   │   ├── Admin.php
│   │   ├── Tenant.php
│   │   └── Task.php
│   ├── Observers/
│   ├── Policies/
│   ├── Providers/
│   ├── Repositories/
│   │   ├── TenantRepository.php
│   │   └── TaskRepository.php
│   └── Services/
│       ├── TenantService.php
│       ├── TenantSchemaService.php
│       ├── TaskService.php
│       └── AdminAuthService.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── auth.php
│   └── tenant.php
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── tenant/                    # Tenant-specific migrations
│   │   │   └── 2024_01_01_000001_create_tasks_table.php
│   │   └── 0001_01_01_000001_create_tenants_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       ├── TenantSeeder.php
│       ├── TaskSeeder.php
│       └── DatabaseSeeder.php
├── docs/
│   └── testing-guide.md
├── public/
│   └── index.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── admin.blade.php
│   │   │   └── tenant.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── login.blade.php
│   │   │   └── tenants/
│   │   │       ├── index.blade.php
│   │   │       ├── show.blade.php
│   │   │       ├── create.blade.php
│   │   │       └── edit.blade.php
│   │   ├── tenant/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php
│   │   │   │   └── register.blade.php
│   │   │   └── tasks/
│   │   │       ├── index.blade.php
│   │   │       ├── show.blade.php
│   │   │       ├── create.blade.php
│   │   │       └── edit.blade.php
│   │   ├── errors/
│   │   │   ├── 404.blade.php
│   │   │   └── 403.blade.php
│   │   └── components/
│   │       └── flash-messages.blade.php
│   └── css/
│   └── js/
├── routes/
│   ├── web.php          # Main routes file
│   ├── admin.php        # Admin routes
│   └── tenant.php       # Tenant routes
├── storage/
├── tests/
└── README.md
```

## 📸 Screenshots

### Admin Panel
- **Login**: Clean blue gradient login form
- **Dashboard**: Statistics cards with tenant counts
- **Tenant Management**: List view with actions

### Tenant Portal
- **Login**: Indigo themed login page
- **Dashboard**: Welcome message with task statistics
- **Task List**: Responsive table with status badges
- **Task Forms**: Clean forms with validation

### UI Components
- Flash messages with icons
- Responsive navigation
- Card-based layouts
- Status badges
- Form validation display

## 🎨 Design System

### Color Palette
- **Primary**: Indigo (#4f46e5)
- **Success**: Green (#10b981)
- **Warning**: Yellow (#f59e0b)
- **Danger**: Red (#ef4444)
- **Neutral**: Gray scale

### Typography
- System fonts for optimal performance
- Clear hierarchy with proper heading sizes
- Readable line heights

### Components
- Cards with shadows
- Responsive tables
- Form inputs with focus states
- Button variants
- Navigation menus

## 🔧 Configuration

### Environment Variables

```env
APP_NAME="Multi-Tenant App"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel_tenant_db
DB_USERNAME=postgres
DB_PASSWORD=

# Tenant Configuration
TENANT_ADMIN_PREFIX=admin
TENANT_DEFAULT_SCHEMA=public
```

### Cache Configuration

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TaskTest
```

### Test Coverage

```bash
php artisan test --coverage
```

See [docs/testing-guide.md](docs/testing-guide.md) for comprehensive testing scenarios.

## 📊 Database Schema

### Public Schema (Shared)
```sql
tenants
├── id
├── name
├── tenant_name (unique)
├── email
├── domain (unique)
├── schema_name (unique)
├── status
└── timestamps

admins
├── id
├── name
├── email (unique)
├── password
└── timestamps
```

### Tenant Schema (Per Tenant)
```sql
users
├── id
├── name
├── email
├── password
├── tenant_id
└── timestamps

tasks
├── id
├── title
├── description
├── status (pending/in_progress/completed)
├── due_date
├── created_by (FK: users)
├── assigned_to (FK: users)
└── timestamps
```

## 🔐 Security

- **Authentication**: Role-based (Admin/Tenant)
- **Authorization**: Resource ownership checks
- **CSRF Protection**: Enabled on all forms
- **SQL Injection**: Prevented via Eloquent ORM
- **XSS Protection**: Blade auto-escaping
- **Password Hashing**: bcrypt
- **Session Security**: Secure session handling

## 🚀 Production Deployment

### Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database credentials
- [ ] Run migrations: `php artisan migrate:fresh --seed`
- [ ] Set up cron job for scheduler (if needed)
- [ ] Configure queue worker (if using queues)
- [ ] Set up SSL certificates
- [ ] Configure web server (Nginx/Apache)
- [ ] Set proper file permissions
- [ ] Enable OPcache
- [ ] Configure backup strategy

### Performance Optimization

```bash
# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📞 Support

For support, email support@example.com or create an issue in the repository.

---

**Built with ❤️ using Laravel 12 and PostgreSQL**