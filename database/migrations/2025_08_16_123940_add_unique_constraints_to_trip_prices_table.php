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
        Schema::table('trip_prices', function (Blueprint $table) {
            $table->unique(['trip_id', 'room_type'], 'trip_prices_trip_room_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_prices', function (Blueprint $table) {
            $table->dropUnique('trip_prices_trip_room_unique');
        });
    }
};
