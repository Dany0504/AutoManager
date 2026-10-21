<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->text('diagnosis')
                ->nullable()
                ->after('notes');

            $table->decimal('estimated_cost', 10, 2)
                ->nullable()
                ->after('diagnosis');

            $table->string('authorization_status', 30)
                ->default('pendiente')
                ->after('estimated_cost');

            $table->timestamp('diagnosis_submitted_at')
                ->nullable()
                ->after('authorization_status');

            $table->timestamp('authorized_at')
                ->nullable()
                ->after('diagnosis_submitted_at');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->dropColumn([
                'diagnosis',
                'estimated_cost',
                'authorization_status',
                'diagnosis_submitted_at',
                'authorized_at',
            ]);

        });
    }
};