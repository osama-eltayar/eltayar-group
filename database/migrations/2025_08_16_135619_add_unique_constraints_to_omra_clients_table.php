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
        Schema::table('omra_clients', function (Blueprint $table) {
            $table->unique(['omra_id', 'client_id'], 'omra_clients_omra_client_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('omra_clients', function (Blueprint $table) {
            $table->dropUnique('omra_clients_omra_client_unique');
        });
    }
};
