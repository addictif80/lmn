<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SoftDeletes
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('slug');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('order_number');
            $table->index(['user_id', 'status']);
        });

        // Performance indexes
        Schema::table('quotes', function (Blueprint $table) {
            $table->index('quote_number');
            $table->index('status');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['date', 'time', 'appointment_type_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['date', 'time', 'appointment_type_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropIndex(['quote_number']);
            $table->dropIndex(['status']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['order_number']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['slug']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
