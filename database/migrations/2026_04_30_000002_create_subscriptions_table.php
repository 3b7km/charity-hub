<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charity_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('donor_id');
            $table->uuid('campaign_id');
            $table->string('stripe_subscription_id', 255)->unique()->nullable();
            $table->string('stripe_customer_id', 255)->nullable();
            $table->enum('plan', ['monthly', 'quarterly', 'annually']);
            $table->enum('status', ['active', 'past_due', 'cancelled', 'trialing'])->default('active');
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->foreign('donor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();

            $table->index('status');
            $table->index('donor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charity_subscriptions');
    }
};
