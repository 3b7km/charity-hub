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
        Schema::create('beneficiary_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('campaign_id')->constrained()->onDelete('cascade');
            $table->string('location_name');        // "Cairo, Egypt"
            $table->decimal('latitude', 10, 7);     // 30.0444196
            $table->decimal('longitude', 10, 7);    // 31.2357116
            $table->integer('beneficiary_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_locations');
    }
};
