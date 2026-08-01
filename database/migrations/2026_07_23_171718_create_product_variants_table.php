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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('sku')->unique();

            $table->string('account_type')->nullable();

            $table->unsignedInteger('duration_value')->nullable();
            $table->string('duration_unit')->nullable();

            $table->unsignedInteger('user_limit')->nullable();
            $table->unsignedInteger('profile_limit')->nullable();

            $table->text('warranty_text')->nullable();
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('compare_price')->nullable();

            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('minimum_stock')->default(3);

            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
