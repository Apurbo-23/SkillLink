<?php
// Quick admin check script
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$admin = \App\Models\User::where('email', 'admin@admin.io')->first();

echo "=== ADMIN USER CHECK ===" . PHP_EOL . PHP_EOL;

if (!$admin) {
    echo "❌ Admin user NOT FOUND" . PHP_EOL;
    echo "Please run: php artisan db:seed --class=AdminSeeder" . PHP_EOL;
    exit(1);
}

echo "✓ Admin user found" . PHP_EOL;
echo "  Name: {$admin->name}" . PHP_EOL;
echo "  Email: {$admin->email}" . PHP_EOL;
echo "  Is Admin: " . ($admin->is_admin ? "YES ✓" : "NO ✗") . PHP_EOL;
echo "  Email Verified: " . ($admin->email_verified_at ? "YES ✓" : "NO ✗") . PHP_EOL;
echo PHP_EOL;

$issues = [];

if (!$admin->is_admin) {
    $issues[] = "is_admin flag is FALSE - fixing...";
    $admin->update(['is_admin' => true]);
    echo "✓ Fixed: is_admin set to TRUE" . PHP_EOL;
}

if (!$admin->email_verified_at) {
    $issues[] = "email_verified_at is NULL - fixing...";
    $admin->update(['email_verified_at' => now()]);
    echo "✓ Fixed: email_verified_at set to now()" . PHP_EOL;
}

echo PHP_EOL;

if (empty($issues)) {
    echo "✓ All checks passed! Admin is ready to use." . PHP_EOL;
    echo PHP_EOL;
    echo "Login credentials:" . PHP_EOL;
    echo "  Email: admin@admin.io" . PHP_EOL;
    echo "  Password: admin123" . PHP_EOL;
} else {
    echo "⚠ Issues were found and fixed:" . PHP_EOL;
    foreach ($issues as $issue) {
        echo "  - {$issue}" . PHP_EOL;
    }
}

echo PHP_EOL . "Access admin dashboard at: /admin/dashboard" . PHP_EOL;
?>
