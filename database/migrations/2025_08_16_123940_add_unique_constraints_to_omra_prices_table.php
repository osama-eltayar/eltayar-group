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
        Schema::table('omra_prices', function (Blueprint $table) {
            $table->unique(['omra_id', 'room_type'], 'omra_prices_omra_room_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('omra_prices', function (Blueprint $table) {
            $table->dropUnique('omra_prices_omra_room_unique');
        });
    }
};
