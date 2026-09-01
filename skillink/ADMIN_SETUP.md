# Admin Panel Setup & Usage Guide

## 🔐 Admin Credentials

The following admin accounts have been created with the @admin.io email extension:

### Primary Admin Account
- **Email:** admin@admin.io
- **Password:** admin123
- **Role:** Administrator

### Support Admin Account
- **Email:** support@admin.io
- **Password:** support123
- **Role:** Administrator

⚠️ **IMPORTANT:** Change these passwords immediately in production!

---

## 🚀 How to Access the Admin Panel

1. Go to: http://127.0.0.1:8000/login (or your production URL)
2. Enter admin email (e.g., `admin@admin.io`)
3. Enter password (e.g., `admin123`)
4. After login, go to: http://127.0.0.1:8000/admin/dashboard

---

## 📊 Admin Dashboard Features

### 1. **Dashboard Home** (`/admin/dashboard`)
- View quick statistics:
  - Open Disputes count
  - Pending Listings count
  - Suspended Users count
  - Total Users count
- See recent open disputes for quick access
- Quick action buttons to access all management sections

### 2. **Dispute Management** (`/admin/disputes`)
- View all open disputes raised by users
- For each dispute, see:
  - User who raised the dispute
  - Reason for the dispute
  - Related swap details (Swap ID, Requester, Provider, Status)
  - Timestamps
- **Actions:**
  - ✓ **Resolve Dispute** - Mark as resolved with admin notes
  - ✕ **Dismiss Dispute** - Dismiss the dispute with admin notes

### 3. **Listings Management** (`/admin/listings`)
- View all user skill listings
- See status of each listing (Active, Pending, Removed)
- **Actions:**
  - **Approve** - Activate a pending listing
  - **Remove** - Remove/flag an inappropriate listing

### 4. **Users Management** (`/admin/users`)
- View all users in the system
- See user details:
  - Name and Email
  - Role (Admin/User)
  - Credit balance
  - Account status (Active/Suspended)
  - Join date
- **Actions:**
  - **Suspend** - Disable user account (prevents participation in swaps)
  - **Unsuspend** - Re-enable suspended user account
- **Note:** Admin accounts are protected and cannot be suspended

---

## 🎯 Common Admin Tasks

### Task 1: Resolve a Dispute
1. Go to `/admin/disputes`
2. Find the open dispute
3. Review the reason and swap details
4. Add admin notes explaining your decision
5. Click either:
   - "✓ Resolve Dispute" to approve resolution
   - "✕ Dismiss Dispute" to reject the dispute
6. Admin notes are saved for record keeping

### Task 2: Approve a Pending Listing
1. Go to `/admin/listings`
2. Find listings with "Pending" status
3. Click "Approve" button
4. Listing becomes active and visible to all users

### Task 3: Remove an Inappropriate Listing
1. Go to `/admin/listings`
2. Find the problematic listing
3. Click "Remove" button
4. Listing is marked as removed and hidden from users

### Task 4: Suspend a User
1. Go to `/admin/users`
2. Find the user to suspend
3. Click "Suspend" button
4. Confirm the action
5. User account is disabled - they cannot participate in new swaps

### Task 5: Unsuspend a User
1. Go to `/admin/users`
2. Filter by "Suspended Users" (optional)
3. Find the user to restore
4. Click "Unsuspend" button
5. User account is re-enabled

---

## 🔒 Security Notes

1. **Email Format:** Only users with `@admin.io` email can create admin accounts
2. **Authentication:** Admin routes require both `auth` and `admin` middleware
3. **Protected Admins:** Admins cannot suspend other admins
4. **Admin-Only Access:** All admin routes are at `/admin/` prefix and require admin role

---

## 📱 Admin Panel Features Summary

| Feature | Route | Description |
|---------|-------|-------------|
| Dashboard | `/admin/dashboard` | Overview with statistics |
| Disputes | `/admin/disputes` | Review and resolve disputes |
| Listings | `/admin/listings` | Approve or remove listings |
| Users | `/admin/users` | Manage user accounts |

---

## 🛠 API Endpoints (Backend)

### Disputes
- `GET /admin/disputes` - List all open disputes
- `PATCH /admin/disputes/{dispute}` - Resolve a dispute

### Listings
- `GET /admin/listings` - List all listings
- `PATCH /admin/listings/{listing}/approve` - Approve listing
- `PATCH /admin/listings/{listing}/remove` - Remove listing

### Users
- `GET /admin/users` - List all users
- `PATCH /admin/users/{user}/suspend` - Suspend user
- `PATCH /admin/users/{user}/unsuspend` - Unsuspend user

---

## 🎨 Styling & Design

The admin panel uses the SkillLink color scheme:
- **Primary Gold:** #D4AF37
- **Dark Background:** #0B0A09
- **Card Background:** #121110 / #1a1814
- **Text:** #e8dfc8
- **Muted Text:** #9a8a6a
- **Error/Alert:** #f5b7b1
- **Success:** #4CAF50
- **Danger:** #f44336

All views are responsive and mobile-friendly.

---

## 📝 Notes for Admins

1. **Regular Review:** Check the dashboard daily for new disputes
2. **Fair Resolution:** Always review both sides before resolving disputes
3. **Documentation:** Use admin notes to document your decisions
4. **User Protection:** Only suspend users who violate community guidelines
5. **Listing Quality:** Maintain quality standards by reviewing listings

---

## ✅ Verification

To verify the admin setup is working:

1. Run the seeder: `php artisan db:seed --class=AdminSeeder`
2. Navigate to `/admin/dashboard`
3. Login with admin@admin.io / admin123
4. Confirm you can access all admin sections

---

**Setup completed successfully!** 🎉

The admin panel is now ready to use. Access it at `/admin/dashboard` after logging in.
