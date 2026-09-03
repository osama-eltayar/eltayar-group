<?php

use App\Enums\RoomType;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->morphs('bookable');
            $table->string('room_type')->default(RoomType::Default->value);
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('number_of_clients');
            $table->unsignedInteger('total_price')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->unsignedInteger('final_price')->nullable();
            $table->unsignedInteger('balance')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
