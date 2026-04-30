<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('donation_id');
            $table->enum('type', ['credit', 'debit', 'refund']);
            $table->unsignedInteger('amount'); // In cents
            $table->unsignedBigInteger('balance_after'); // Running campaign balance
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // NO updated_at, NO deleted_at — this table is immutable (append-only)

            $table->foreign('donation_id')->references('id')->on('donations')->cascadeOnDelete();

            $table->index('donation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
