<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Corrige bases de datos donde las migraciones de configuración ya corrieron
 * en su versión anterior: create_workshop_settings_table creaba por error
 * appointment_settings, así que workshop_settings nunca se creó.
 *
 * Solo crea lo que falte; en una base de datos nueva no hace nada.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('workshop_settings')) {
            Schema::create('workshop_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('rfc', 13)->nullable();
                $table->string('phone', 30)->nullable();
                $table->text('address')->nullable();
                $table->string('email')->nullable();
                $table->decimal('tax_percentage', 5, 2)->default(16);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('appointment_settings')) {
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
    }

    public function down(): void
    {
        // No se borra nada: estas tablas pertenecen a sus migraciones originales.
    }
};
