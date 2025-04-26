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
        Schema::create('booking_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('booking_id')->constrained();
            $table->string('room_type')->default(\App\Enums\RoomType::Default->value);
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->unsignedInteger('final_price')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_clients');
    }
};
