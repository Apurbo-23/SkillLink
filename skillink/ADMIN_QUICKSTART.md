# Admin Panel - Quick Start Guide

## 🚀 Getting Started (30 seconds)

### 1. Verify Setup
```bash
php check-admin.php
```
✓ Shows if admin is ready

### 2. Login
- Go to: `http://127.0.0.1:8000/login`
- Email: `admin@admin.io`
- Password: `admin123`

### 3. Access Dashboard
After login, you'll be at: `http://127.0.0.1:8000/admin/dashboard`

---

## 📋 Admin Functions

### View Dashboard
- **URL:** `/admin/dashboard`
- **Shows:** Statistics, recent disputes, quick actions

### Manage Disputes
- **URL:** `/admin/disputes`
- **Do:** Review, resolve, or dismiss disputes
- **Actions:** Add notes, mark as resolved/dismissed

### Manage Listings
- **URL:** `/admin/listings`
- **Do:** Approve or remove user listings
- **Actions:** Approve pending listings, remove inappropriate ones

### Manage Users
- **URL:** `/admin/users`
- **Do:** View users, suspend accounts
- **Actions:** Suspend/unsuspend users, view user stats

---

## 🔑 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@admin.io | admin123 |
| Support | support@admin.io | support123 |

⚠️ **Change these passwords in production!**

---

## 🔍 Troubleshooting

### Issue: Not redirected to admin dashboard after login

**Solution:**
1. Clear browser cache (Ctrl+Shift+Delete)
2. Try in incognito/private mode
3. Restart server: Stop (Ctrl+C) and run `php artisan serve --port=8000`

### Issue: "Admin only" error

**Solution:**
1. Run: `php check-admin.php`
2. Verify `is_admin` shows "YES"
3. If shows "NO", it will auto-fix

### Issue: Can't see admin link in dropdown

**Solution:**
1. Make sure you're logged in as admin
2. Refresh the page (Ctrl+F5)
3. Check that `is_admin=true` with `php check-admin.php`

---

## 📊 Dashboard Overview

### Stats Cards
- Open Disputes - Number of active disputes
- Pending Listings - Listings awaiting approval
- Suspended Users - Disabled accounts
- Total Users - Non-admin users

### Recent Disputes Widget
- Shows last 5 open disputes
- Quick "Review" link for each
- Raised by, reason, swap ID

### Quick Actions
- Review Disputes button
- Manage Listings button
- Manage Users button

---

## ✅ What's New

**Fixed Issues:**
- ✓ Admin redirect after login
- ✓ Admin link in navigation
- ✓ Diagnostic tools for verification
- ✓ Auto-fix for admin setup issues

**New Files:**
- `check-admin.php` - Diagnostic script
- `ADMIN_SETUP.md` - Complete setup guide
- `ADMIN_TROUBLESHOOTING.md` - Detailed troubleshooting
- `ADMIN_FIX_SUMMARY.md` - What was fixed

---

## 🎯 Next Steps

1. **Verify:** Run `php check-admin.php`
2. **Login:** Go to `/login` with admin credentials
3. **Navigate:** Access `/admin/dashboard`
4. **Explore:** Try each section (Disputes, Listings, Users)
5. **Secure:** Change default passwords

---

## 💡 Pro Tips

1. **Bookmark:** `/admin/dashboard` for quick access
2. **Check Often:** Review disputes daily
3. **Document:** Use admin notes to record decisions
4. **Monitor:** Watch for trends in disputes/removals

---

**Admin panel is ready to use!** 🎉

For detailed information, see:
- `ADMIN_SETUP.md` - Full setup documentation
- `ADMIN_TROUBLESHOOTING.md` - Troubleshooting guide
- `ADMIN_FIX_SUMMARY.md` - Technical changes made
