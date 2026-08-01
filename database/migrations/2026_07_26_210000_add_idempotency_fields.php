<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->string('checkout_token', 64)
                ->nullable()
                ->unique()
                ->after('user_id');
        });

        Schema::table('payments', function (Blueprint $table): void {
            $table->string('last_notification_hash', 64)
                ->nullable()
                ->index()
                ->after('raw_response');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->dropIndex(['last_notification_hash']);
            $table->dropColumn('last_notification_hash');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->dropUnique(['checkout_token']);
            $table->dropColumn('checkout_token');
        });
    }
};
