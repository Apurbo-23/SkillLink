<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Minimal placeholder so the public profile page has something real
     * to show for "ratings". The full 5-star + review flow is a separate
     * module - this covers just enough (rater, rated user, score) for a
     * profile to display an average rating and count.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rated_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('swap_request_id')->nullable()->constrained('swap_requests')->nullOnDelete();
            $table->unsignedTinyInteger('score'); // 1-5
            $table->string('review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
