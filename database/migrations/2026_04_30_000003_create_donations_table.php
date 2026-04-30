<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id');
            $table->uuid('donor_id');
            $table->unsignedInteger('amount'); // In cents, never float
            $table->char('currency', 3)->default('GBP');
            $table->enum('gateway', ['stripe', 'paymob']);
            $table->string('gateway_ref', 255)->nullable(); // Stripe PaymentIntent ID
            $table->string('idempotency_key', 255)->unique()->nullable();
            $table->enum('status', ['pending', 'confirmed', 'failed', 'refunded'])->default('pending');
            $table->enum('type', ['one_time', 'recurring']);
            $table->uuid('subscription_id')->nullable();
            $table->string('certificate_path', 500)->nullable();
            $table->timestamp('donated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('donor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('subscription_id')->references('id')->on('charity_subscriptions')->nullOnDelete();

            $table->index('gateway_ref');
            $table->index('status');
            $table->index(['campaign_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
