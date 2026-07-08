# Application Testing Guide

## Prerequisites
1. Run migrations: `php artisan migrate:fresh --seed`
2. Start server: `php artisan serve`
3. Configure hosts file for tenant domains

## Test Scenarios

### 1. Schema Creation Tests

#### Test 1.1: Tenant Schema Creation
**Steps:**
1. Login as admin: `admin@example.com` / `password`
2. Navigate to Admin Dashboard
3. Create new tenant with domain: `test.test`
4. Click "Initialize Tenant"

**Expected Result:**
- ✅ Tenant record created in database
- ✅ PostgreSQL schema `tenant_test` created
- ✅ Tenant migrations run automatically
- ✅ Default tenant user created
- ✅ Success flash message displayed

**Verification:**
```sql
-- Connect to PostgreSQL and verify
SELECT schema_name FROM information_schema.schemata 
WHERE schema_name = 'tenant_test';
```

---

### 2. Schema Switching Tests

#### Test 2.1: Automatic Schema Switching
**Steps:**
1. Visit `http://test.test/` in browser
2. Check PostgreSQL connections

**Expected Result:**
- ✅ IdentifyTenant middleware activates
- ✅ Schema switches to `tenant_test`
- ✅ All queries execute in tenant schema
- ✅ Schema resets to `public` after request

**Verification:**
Add logging in TenantSchemaService::switchToSchema():
```php
Log::info('Schema switched', ['schema' => $schemaName]);
```

---

### 3. Tenant Isolation Tests

#### Test 3.1: Data Isolation Between Tenants
**Steps:**
1. Create Tenant A: `tenant-a.test` with User A
2. Create Tenant B: `tenant-b.test` with User B
3. Login as User A on `tenant-a.test`
4. Create tasks as User A
5. Login as User B on `tenant-b.test`
6. Try to access `tenant-a.test` data

**Expected Result:**
- ✅ Tenant A users see ONLY Tenant A tasks
- ✅ Tenant B users see ONLY Tenant B tasks
- ✅ No cross-tenant data visibility
- ✅ Separate PostgreSQL schemas

**Verification:**
```sql
-- Schema A should have different data than Schema B
SELECT * FROM tenant_a.tasks;  -- Only Tenant A tasks
SELECT * FROM tenant_b.tasks;  -- Only Tenant B tasks
```

#### Test 3.2: Prevent Schema Bypass
**Steps:**
1. Try to access another tenant's schema via SQL injection (if possible)
2. Try to manually switch search_path

**Expected Result:**
- ✅ PostgreSQL permissions prevent cross-schema access
- ✅ Middleware ensures correct schema per request
- ✅ No application-level data leakage

---

### 4. Authentication Tests

#### Test 4.1: Admin Authentication
**Steps:**
1. Visit `http://127.0.0.1:8000/admin/login`
2. Login with: `admin@example.com` / `password`

**Expected Result:**
- ✅ Login form displays
- ✅ Successful login redirects to dashboard
- ✅ Admin auth guard activated
- ✅ Session created

**Test Invalid Admin:**
- Wrong password → Error message
- Non-existent email → Error message

#### Test 4.2: Tenant User Authentication
**Steps:**
1. Visit `http://tenant-a.test/tenant/login`
2. Login with tenant user credentials

**Expected Result:**
- ✅ Login form displays with tenant branding
- ✅ Successful login redirects to tenant dashboard
- ✅ Web auth guard activated
- ✅ User context available

#### Test 4.3: Logout
**Steps:**
1. Login as any user
2. Click logout

**Expected Result:**
- ✅ Session invalidated
- ✅ Redirected to login page
- ✅ Cannot access protected routes after logout

---

### 5. CRUD Operation Tests

#### Test 5.1: Task CRUD (Tenant)
**Steps:**
1. Login as tenant user
2. Navigate to Tasks
3. **Create:** Add new task
4. **Read:** View task list
5. **View Details:** Click task to view
6. **Update:** Edit task
7. **Delete:** Remove task

**Expected Results:**
- ✅ Task created with validation
- ✅ Task list displays with pagination
- ✅ Task details show all fields
- ✅ Task updates successfully
- ✅ Task deleted with confirmation
- ✅ Flash messages for each action
- ✅ Validation errors displayed

**Validation Tests:**
- Empty title → Error
- Invalid status → Error
- Invalid date → Error
- Title > 255 chars → Error

#### Test 5.2: Tenant CRUD (Admin)
**Steps:**
1. Login as admin
2. Navigate to Tenants
3. **Create:** Add new tenant
4. **Read:** View tenant list
5. **View:** See tenant details
6. **Update:** Edit tenant
7. **Activate/Deactivate:** Toggle status
8. **Initialize:** Run migrations
9. **Delete:** Remove tenant

**Expected Results:**
- ✅ Tenant created with schema
- ✅ Tenant list displays
- ✅ Tenant details show users and stats
- ✅ Tenant updates correctly
- ✅ Status changes reflected in middleware
- ✅ Initialization creates schema and migrations
- ✅ Deletion removes schema and record

---

### 6. Middleware Tests

#### Test 6.1: Admin Middleware
**Steps:**
1. Visit `/admin/dashboard` without login

**Expected Result:**
- ✅ Redirected to login page

2. Login as admin
3. Visit `/admin/dashboard`

**Expected Result:**
- ✅ Dashboard displays

#### Test 6.2: Tenant Auth Middleware
**Steps:**
1. Visit `/tasks` without login

**Expected Result:**
- ✅ Redirected to tenant login

2. Login as tenant user
3. Visit `/tasks`

**Expected Result:**
- ✅ Task list displays

#### Test 6.3: Tenant Status Check
**Steps:**
1. Deactivate a tenant (admin)
2. Try to access tenant portal

**Expected Result:**
- ✅ 403 Forbidden displayed
- ✅ Tenant cannot access application

---

### 7. Dashboard Tests

#### Test 7.1: Admin Dashboard
**Steps:**
1. Login as admin
2. View dashboard

**Expected Result:**
- ✅ Total tenants displayed
- ✅ Active/inactive counts
- ✅ Quick links working

#### Test 7.2: Tenant Dashboard
**Steps:**
1. Login as tenant user
2. View dashboard

**Expected Result:**
- ✅ Welcome message with user name
- ✅ Total tasks count
- ✅ Pending tasks count
- ✅ Completed tasks count
- ✅ Stats accurate

---

### 8. Error Handling Tests

#### Test 8.1: 404 Error
**Steps:**
1. Visit non-existent URL: `/non-existent-page`

**Expected Result:**
- ✅ Custom 404 page displays
- ✅ proper styling
- ✅ Navigation options available

#### Test 8.2: 403 Error
**Steps:**
1. Try to access another user's task

**Expected Result:**
- ✅ Custom 403 page displays
- ✅ Clear access denied message

#### Test 8.3: Validation Errors
**Steps:**
1. Submit form with invalid data

**Expected Result:**
- ✅ Errors displayed in red
- ✅ Flash messages component shows errors
- ✅ Form retains old input
- ✅ Specific field errors shown

---

## Automated Test Checklist

### Database Tests
- [ ] AdminSeeder creates admin user
- [ ] TenantSeeder creates tenant with users
- [ ] TaskSeeder creates sample tasks
- [ ] Foreign keys work correctly
- [ ] Cascade deletes function

### Middleware Tests
- [ ] IdentifyTenant switches schema
- [ ] AdminMiddleware blocks non-admins
- [ ] TenantAuthMiddleware redirects guests
- [ ] Schema resets after each request

### Model Tests
- [ ] Task relationships load correctly
- [ ] Tenant relationships work
- [ ] UUIDs generated properly
- [ ] Fillable fields restrict correctly

### Controller Tests
- [ ] Validation rules enforced
- [ ] Authorization checks work
- [ ] Flash messages set correctly
- [ ] Redirects go to correct routes

### View Tests
- [ ] All views render without errors
- [ ] Forms have CSRF tokens
- [ ] Error displays work
- [ ] Pagination works

---

## Performance Tests

### Database
- [ ] Queries execute within acceptable time
- [ ] No N+1 query problems
- [ ] Pagination works efficiently
- [ ] Indexes used properly

### Schema Switching
- [ ] No performance degradation
- [ ] Connection pooling works
- [ ] No schema leakage between requests

---

## Security Tests

- [ ] CSRF protection active
- [ ] SQL injection prevented
- [ ] XSS protection active (Blade escaping)
- [ ] Password hashing works
- [ ] Session fixation prevention
- [ ] Authorization checks enforced

---

## Browser Compatibility

Test in:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

---

## Known Limitations

1. **Tenant Discovery:** Currently uses domain/subdomain only
2. **File Storage:** Files stored in default disk (not tenant-aware)
3. **Email:** Email not configured per tenant
4. **API:** No API rate limiting per tenant

---

## Test Results

### Passed Tests
_To be filled during testing_

### Failed Tests
_To be filled during testing_

### Bugs Found
_To be filled during testing_