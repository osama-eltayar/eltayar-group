<?php

use App\Enums\HajClientStatus;
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
        Schema::table('haj_clients', function (Blueprint $table): void {
            $table->string('status')->default(HajClientStatus::NoShow->value)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('haj_clients', function (Blueprint $table): void {
            $table->string('status')->default('pending')->change();
        });
    }
};
