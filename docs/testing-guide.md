# Testing Guide

## Run

```bash
php artisan migrate:fresh --seed
php artisan test
php artisan serve
```

## What to Verify

- Admin login
- Tenant login
- Tenant dashboard
- Task CRUD
- Schema isolation
- Logout
- Validation errors
- 403 and 404 pages

## Notes

- Admin data must stay in `public`.
- Tenant data must stay in the tenant schema.
- If the tenant schema is missing, re-run the seeder.

