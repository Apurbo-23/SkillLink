<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('skill_offering_attachments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('skill_offering_id')->constrained()->cascadeOnDelete();
        $table->string('type'); // 'file' or 'link'
        $table->string('original_name')->nullable(); // e.g. "portfolio.pdf"
        $table->string('path')->nullable();           // storage path, for uploaded files
        $table->string('url')->nullable();             // for external links
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_offering_attachments');
    }
};
