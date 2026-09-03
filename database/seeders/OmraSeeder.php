<?php

namespace Database\Seeders;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Enums\RoomType;
use App\Models\Omra;
use App\Models\OmraPrice;
use Illuminate\Database\Seeder;

class OmraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $omras = [
            [
                'description' => 'رحلة عمرة مميزة لعام 2025 مع إقامة فاخرة وخدمات متميزة',
                'started_at' => '2025-06-15',
                'ended_at' => '2025-06-30',
                'price' => 3500,
            ],
            [
                'description' => 'رحلة عمرة اقتصادية لعام 2025 مع إقامة مريحة وخدمات جيدة',
                'started_at' => '2025-07-01',
                'ended_at' => '2025-07-16',
                'price' => 3200,
            ],
        ];

        foreach ($omras as $omraData) {
            $omra = Omra::create([
                'name' => Omra::generateHijriName(new \DateTime($omraData['started_at'])),
                'description' => $omraData['description'],
                'started_at' => $omraData['started_at'],
                'ended_at' => $omraData['ended_at'],
                'status' => PackageStatus::Active,
                'type' => PackageType::Flight,
                'maximum_allowed' => 40,
            ]);

            OmraPrice::create([
                'omra_id' => $omra->id,
                'room_type' => RoomType::Default,
                'price' => $omraData['price'],
                'is_active' => true,
            ]);
        }
    }
}
