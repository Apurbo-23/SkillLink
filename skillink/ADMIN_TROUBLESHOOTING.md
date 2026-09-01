# Admin Panel Troubleshooting & Testing

## 🔍 Verify Admin Setup

### Step 1: Check if Admin User Exists
Visit: `http://127.0.0.1:8000/admin-check`

You should see a JSON response like:
```json
{
  "found": true,
  "name": "Admin",
  "email": "admin@admin.io",
  "is_admin": true,
  "email_verified_at": "2026-09-01T...",
  "created_at": "2026-09-01T..."
}
```

**If you see `"is_admin": false`** → Run this to fix:
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'admin@admin.io')->first();
>>> $user->update(['is_admin' => true]);
>>> exit
```

**If you see `"email_verified_at": null`** → Run this to fix:
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'admin@admin.io')->first();
>>> $user->update(['email_verified_at' => now()]);
>>> exit
```

---

## ✅ Testing Login Flow

### Step 1: Go to Login Page
```
http://127.0.0.1:8000/login
```

### Step 2: Login with Admin Credentials
- **Email:** `admin@admin.io`
- **Password:** `admin123`

### Step 3: Check Redirect
After login, you should be redirected to:
```
http://127.0.0.1:8000/admin/dashboard
```

**If redirected to `/dashboard` instead:**
- This means the `is_admin` flag is not set to `true`
- Follow the "Fix `is_admin` flag" steps above

---

## 🛠 Quick Fixes

### Fix 1: Re-seed Admin User
If the admin user doesn't exist or is corrupted:

```bash
# Delete the admin user first (optional)
php artisan tinker
>>> App\Models\User::where('email', 'admin@admin.io')->delete();
>>> exit

# Re-seed
php artisan db:seed --class=AdminSeeder
```

### Fix 2: Manual Admin User Creation
```bash
php artisan tinker
>>> App\Models\User::create([
...   'name' => 'Admin',
...   'email' => 'admin@admin.io',
...   'password' => bcrypt('admin123'),
...   'is_admin' => true,
...   'email_verified_at' => now(),
... ]);
>>> exit
```

### Fix 3: Check Routes
```bash
php artisan route:list | grep admin
```

You should see:
```
admin/dashboard ............ GET|HEAD admin.dashboard
admin/disputes ............ GET|HEAD admin.disputes
admin/listings ............ GET|HEAD admin.listings
admin/users ............ GET|HEAD admin.users
```

---

## 🔐 After Login Navigation

Once logged in as admin, you should see:

1. **Dropdown menu** in top-right corner with "Admin Dashboard" link
2. **Admin Dashboard** available at `/admin/dashboard`
3. **Navigation links** in dashboard:
   - Dashboard (current page)
   - Disputes
   - Listings
   - Users

---

## 📋 What Changed

### Files Modified:
1. `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
   - Added check: if user is admin, redirect to `/admin/dashboard`
   - Otherwise, redirect to regular `/dashboard`

2. `resources/views/layouts/navigation.blade.php`
   - Added admin-only link in user dropdown menu
   - Shows "Admin Dashboard" link only for admin users

### New Files Created:
1. `app/Http/Controllers/AdminDebugController.php`
   - Helper for testing admin setup
   - Accessible at `/admin-check`

---

## ✨ Expected Behavior

### Regular User Login:
1. Login with regular user email
2. Redirected to `/dashboard`
3. Cannot access `/admin/*` routes (403 Forbidden)

### Admin Login:
1. Login with `admin@admin.io` or `support@admin.io`
2. Automatically redirected to `/admin/dashboard`
3. See "Admin Dashboard" link in user dropdown
4. Can access all admin routes

---

## 🚀 Next Steps

After verifying admin setup works:

1. **Remove debug route** from `routes/web.php` (the `/admin-check` route) in production
2. **Change admin passwords** from defaults (`admin123`, `support123`)
3. **Create additional admins** as needed with `@admin.io` email
4. **Test all admin features** (disputes, listings, users management)

---

**Need help?** Check the output of `/admin-check` endpoint and follow the Fix steps above.
