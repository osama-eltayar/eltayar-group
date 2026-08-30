<?php

namespace Database\Seeders;

use App\Enums\RoomType;
use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use App\Models\Trip;
use App\Models\TripPrice;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            [
                'description' => 'رحلة حج مميزة لعام 2025 مع إقامة فاخرة وخدمات متميزة',
                'started_at' => '2025-06-15',
                'ended_at' => '2025-06-30',
                'price' => 3500,
            ],
            [
                'description' => 'رحلة حج اقتصادية لعام 2025 مع إقامة مريحة وخدمات جيدة',
                'started_at' => '2025-07-01',
                'ended_at' => '2025-07-16',
                'price' => 3200,
            ],
        ];

        foreach ($trips as $tripData) {
            $trip = Trip::create([
                'name' => Trip::generateHijriName(TripActivity::Hajj, new \DateTime($tripData['started_at'])),
                'description' => $tripData['description'],
                'started_at' => $tripData['started_at'],
                'ended_at' => $tripData['ended_at'],
                'status' => TripStatus::Active,
                'activity' => TripActivity::Hajj,
                'type' => TripType::Flight,
                'maximum_allowed' => 40,
            ]);

            TripPrice::create([
                'trip_id' => $trip->id,
                'room_type' => RoomType::Default,
                'price' => $tripData['price'],
                'is_active' => true,
            ]);
        }
    }
}
