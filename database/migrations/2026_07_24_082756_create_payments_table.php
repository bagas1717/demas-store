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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('gateway')
                ->default('midtrans');

            $table->string('gateway_order_id')
                ->unique();

            $table->string('snap_token')
                ->nullable();

            $table->text('redirect_url')
                ->nullable();

            $table->string('transaction_id')
                ->nullable();

            $table->string('payment_type')
                ->nullable();

            $table->string('transaction_status')
                ->nullable();

            $table->string('fraud_status')
                ->nullable();

            $table->unsignedBigInteger('gross_amount');

            $table->json('raw_response')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamp('expired_at')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
