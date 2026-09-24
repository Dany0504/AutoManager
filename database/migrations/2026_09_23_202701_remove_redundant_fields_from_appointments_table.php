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
    if (Schema::hasColumn('appointments', 'customer_name')) {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('customer_name');
        });
    }

    if (Schema::hasColumn('appointments', 'phone')) {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }

    // 'vehicle' ya no existe, así que no lo intentamos borrar.
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    if (!Schema::hasColumn('appointments', 'customer_name')) {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
        });
    }

    if (!Schema::hasColumn('appointments', 'phone')) {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('phone')->nullable();
        });
    }
}
};
