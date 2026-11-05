<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedInteger('intake_mileage')->nullable();
            $table->string('intake_fuel_level', 20)->nullable();
            $table->text('intake_customer_description')->nullable();
            $table->text('intake_observations')->nullable();

            $table->string('intake_photo_front')->nullable();
            $table->string('intake_photo_left')->nullable();
            $table->string('intake_photo_right')->nullable();
            $table->string('intake_photo_rear')->nullable();

            $table->timestamp('intake_registered_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'intake_mileage',
                'intake_fuel_level',
                'intake_customer_description',
                'intake_observations',
                'intake_photo_front',
                'intake_photo_left',
                'intake_photo_right',
                'intake_photo_rear',
                'intake_registered_at',
            ]);
        });
    }
};