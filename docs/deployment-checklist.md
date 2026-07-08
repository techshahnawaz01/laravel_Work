# Deployment Checklist

Complete checklist for deploying the multi-tenant Laravel application to production.

## Pre-Deployment

### Server Requirements
- [ ] PHP 8.2 or higher installed
- [ ] PostgreSQL 12+ installed and running
- [ ] Composer installed
- [ ] Node.js & NPM installed
- [ ] Web server configured (Nginx/Apache)
- [ ] SSL certificate installed
- [ ] Firewall configured

### Application Setup
- [ ] Clone repository to server
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm install && npm run build`
- [ ] Copy `.env.example` to `.env`
- [ ] Generate app key: `php artisan key:generate`
- [ ] Set proper file permissions:
  ```bash
  chmod -R 755 storage/
  chmod -R 755 bootstrap/cache/
  ```

## Database Configuration

### PostgreSQL Setup
- [ ] Create production database
- [ ] Create database user with strong password
- [ ] Grant necessary privileges
- [ ] Enable required extensions (uuid-ossp, plpgsql)
- [ ] Update `.env` with database credentials

### .env Configuration
```env
APP_NAME="Multi-Tenant App"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=production_db
DB_USERNAME=prod_user
DB_PASSWORD=strong_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Migrations & Seeders

### Database Migration
- [ ] Backup existing database
- [ ] Run migrations: `php artisan migrate:fresh --force`
- [ ] Verify all tables created
- [ ] Check migration status: `php artisan migrate:status`

### Seed Data
- [ ] Run seeders: `php artisan db:seed --force`
- [ ] Verify admin user created
- [ ] Verify sample tenant created
- [ ] Verify tasks seeded

## Laravel Optimization

### Cache & Config
- [ ] Clear all caches:
  ```bash
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  php artisan cache:clear
  ```
- [ ] Optimize for production:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan event:cache
  ```

### Queue Worker
- [ ] Install Supervisor
- [ ] Configure worker
- [ ] Start worker

### Scheduled Tasks
- [ ] Add cron job:
  ```bash
  * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
  ```

## Web Server Configuration

### Nginx Configuration
- [ ] Create site config
- [ ] Enable site
- [ ] Test configuration: `nginx -t`
- [ ] Reload Nginx

### SSL Certificate
- [ ] Install Certbot
- [ ] Obtain certificate
- [ ] Test auto-renewal

## Security Hardening

- [ ] Set APP_DEBUG=false
- [ ] Set strong APP_KEY
- [ ] Enable HTTPS only
- [ ] Set secure session cookie
- [ ] Disable directory listing
- [ ] Set proper file permissions
- [ ] Protect .env file
- [ ] Use strong database passwords
- [ ] Enable PostgreSQL SSL
- [ ] Disable root SSH login
- [ ] Use SSH keys
- [ ] Install fail2ban
- [ ] Enable firewall
- [ ] Keep system updated

## Performance Optimization

- [ ] Enable OPcache
- [ ] Use Redis for cache/session/queue
- [ ] Configure connection pooling
- [ ] Enable gzip compression
- [ ] Set up CDN
- [ ] Optimize images
- [ ] Minify CSS/JS

## Backup Strategy

- [ ] Configure automated daily backups
- [ ] Test backup restoration
- [ ] Store backups offsite
- [ ] Backup retention policy

## Post-Deployment

### Verification
- [ ] Access application URL
- [ ] Test admin login
- [ ] Test tenant portal
- [ ] Verify SSL certificate
- [ ] Check all pages load
- [ ] Test forms
- [ ] Verify flash messages
- [ ] Test error pages
- [ ] Check email sending

### Monitoring
- [ ] Set up health check endpoint
- [ ] Configure uptime monitoring
- [ ] Set up error alerts
- [ ] Monitor disk space
- [ ] Monitor database size

## Final Checks

- [ ] All environment variables set
- [ ] Database connected
- [ ] SSL certificate valid
- [ ] Application accessible
- [ ] Admin panel functional
- [ ] Tenant portals functional
- [ ] Backups configured
- [ ] Monitoring active
- [ ] No debug mode
- [ ] No sensitive data exposed

---

**Deployment completed successfully!**