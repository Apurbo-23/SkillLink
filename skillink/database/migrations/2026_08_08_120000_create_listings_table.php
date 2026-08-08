<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * NOTE: This is a minimal listings table, added only so the swap-request
     * feature has something to point at. If a teammate is already building
     * the full listings module, this migration/model should be merged with
     * theirs rather than kept side by side.
     */
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('skill_offered');
            $table->string('skill_wanted');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active | paused
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
