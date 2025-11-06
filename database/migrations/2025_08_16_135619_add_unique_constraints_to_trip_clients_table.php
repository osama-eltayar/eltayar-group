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
        Schema::table('trip_clients', function (Blueprint $table) {
            $table->unique(['trip_id', 'client_id'], 'trip_clients_trip_client_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_clients', function (Blueprint $table) {
            $table->dropUnique('trip_clients_trip_client_unique');
        });
    }
};
