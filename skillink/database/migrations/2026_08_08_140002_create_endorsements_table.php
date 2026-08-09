<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Minimal placeholder for the endorsements module, matching the
     * functional doc's rule that only users who've completed a swap
     * together can endorse each other. Just enough for the public
     * profile to list "endorsed for X by N people".
     */
    public function up(): void
    {
        Schema::create('endorsements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('endorser_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('endorsed_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('skill');
            $table->timestamps();

            $table->unique(['endorser_id', 'endorsed_user_id', 'skill']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endorsements');
    }
};
