<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table): void {
                $table
                    ->string('username', 30)
                    ->nullable()
                    ->unique()
                    ->after('name');
            });
        }

        if (! Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table): void {
                $table
                    ->string('phone', 30)
                    ->nullable()
                    ->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'two_factor_secret')) {
            Schema::table('users', function (Blueprint $table): void {
                $table
                    ->text('two_factor_secret')
                    ->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'two_factor_recovery_codes')) {
            Schema::table('users', function (Blueprint $table): void {
                $table
                    ->text('two_factor_recovery_codes')
                    ->nullable();
            });
        }

        if (! Schema::hasColumn('users', 'two_factor_confirmed_at')) {
            Schema::table('users', function (Blueprint $table): void {
                $table
                    ->timestamp('two_factor_confirmed_at')
                    ->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('username');
            });
        }

        if (Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('phone');
            });
        }

        /*
         * Jangan hapus kolom 2FA di sini karena kolom tersebut kemungkinan
         * berasal dari migration Fortify lain yang sudah lebih dahulu dibuat.
         */
    }
};