<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Datos generales del taller (pantalla Parámetros del administrador).
 *
 * Nota: una versión anterior de este archivo creaba por error la tabla
 * appointment_settings. Las bases de datos donde ya corrió esa versión
 * se corrigen con 2026_11_16_000000_create_missing_settings_tables.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('workshop_settings')) {
            return;
        }

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

    public function down(): void
    {
        Schema::dropIfExists('workshop_settings');
    }
};
