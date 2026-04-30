<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id');
            $table->unsignedInteger('beneficiary_count')->default(0);
            $table->json('locations')->nullable(); // [{lat, lng, label}]
            $table->longText('summary')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('pdf_path', 500)->nullable();
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();

            $table->index('campaign_id');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_reports');
    }
};
