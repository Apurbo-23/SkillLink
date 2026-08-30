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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();$table->foreignId('swap_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raised_by_id')->constrained('users')->cascadeOnDelete();
            $table->text('reason');
            $table->string('status')->default('open'); // open | resolved | dismissed
            $table->text('admin_notes')->nullable();
            $table->foreignId('resolved_by_id')->nullable()->constrained('users')->nullOnDelete();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
