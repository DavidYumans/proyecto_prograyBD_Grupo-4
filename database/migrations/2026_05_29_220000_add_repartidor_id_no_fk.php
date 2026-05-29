<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'repartidor_id')) {
                $table->unsignedBigInteger('repartidor_id')->nullable();
            }
            if (! Schema::hasColumn('orders', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'repartidor_id')) {
                $table->dropColumn('repartidor_id');
            }
            if (Schema::hasColumn('orders', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }
};
