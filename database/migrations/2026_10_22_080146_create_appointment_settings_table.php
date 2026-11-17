<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Configuración de la agenda de citas (horario, servicios, días bloqueados).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('appointment_settings')) {
            return;
        }

        Schema::create('appointment_settings', function (Blueprint $table) {
            $table->id();
            $table->time('opening_time')->default('08:00:00');
            $table->time('closing_time')->default('18:00:00');
            $table->unsignedInteger('slot_duration')->default(60);
            $table->time('break_start')->nullable();
            $table->json('working_days');
            $table->json('services');
            $table->json('blocked_dates');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_settings');
    }
};
