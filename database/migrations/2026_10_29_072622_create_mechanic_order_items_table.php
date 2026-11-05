<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mechanic_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            $table->enum('type', ['servicio', 'refaccion']);
            $table->string('name', 200);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mechanic_order_items');
    }
};