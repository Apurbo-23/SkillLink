<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * profile_slug is added nullable (safer across DB drivers, especially
     * SQLite, than altering nullability after the fact) and every existing
     * user is immediately backfilled with one. New users always get one
     * too, via a model creating() hook - see App\Models\User.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_slug')->nullable()->after('credits');
        });

        DB::table('users')->whereNull('profile_slug')->orderBy('id')->get(['id', 'name'])->each(function ($user) {
            DB::table('users')->where('id', $user->id)->update([
                'profile_slug' => Str::slug($user->name).'-'.Str::lower(Str::random(6)),
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unique('profile_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['profile_slug']);
            $table->dropColumn('profile_slug');
        });
    }
};
