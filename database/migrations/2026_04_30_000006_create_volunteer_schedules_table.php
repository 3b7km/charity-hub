<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('volunteer_id');
            $table->uuid('campaign_id');
            $table->dateTime('shift_start');
            $table->dateTime('shift_end');
            $table->decimal('hours_logged', 5, 2)->nullable(); // Computed on clock-out
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamp('conflict_checked_at')->nullable();
            $table->timestamps();

            $table->foreign('volunteer_id')->references('id')->on('volunteers')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();

            // Composite index for conflict detection queries
            $table->index(['volunteer_id', 'shift_start']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_schedules');
    }
};
