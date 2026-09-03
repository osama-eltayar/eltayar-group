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
        Schema::create('haj_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('haj_id')->constrained();
            $table->foreignId('booking_id')->nullable()->constrained();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->string('dependency_type');
            $table->foreignId('depends_on_haj_client_id')->nullable()->constrained('haj_clients')->nullOnDelete();
            $table->string('relation_type')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['haj_id', 'client_id'], 'haj_clients_haj_client_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haj_clients');
    }
};
