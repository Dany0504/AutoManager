<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->unsignedBigInteger('client_id')
                  ->nullable()
                  ->after('id');

        });

        DB::table('appointments')->update([
            'client_id' => 1
        ]);

        Schema::table('appointments', function (Blueprint $table) {

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->cascadeOnDelete();

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->foreignId('user_id')->nullable();

            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};