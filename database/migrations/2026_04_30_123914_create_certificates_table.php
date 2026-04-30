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
        Schema::create('certificates', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->uuid('donation_id');
            $table->foreign('donation_id')->references('id')->on('donations')->cascadeOnDelete();
            $table->string('certificate_number')->unique();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
