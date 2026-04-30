<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->json('skills')->nullable();
            $table->json('availability')->nullable(); // Weekly availability map
            $table->decimal('total_hours', 8, 2)->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->text('emergency_contact')->nullable(); // Encrypted via Encryptable trait
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
