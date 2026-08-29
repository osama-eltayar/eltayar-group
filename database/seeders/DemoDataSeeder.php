<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\UserStatus;
use App\Models\Booking;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Transaction;
use App\Models\Trip;
use App\Models\TripClient;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedUsers();

        $clients = $this->seedClients();
        $trips = $this->seedTrips();

        $this->seedBookings($trips, $clients);

        $users = User::all();

        $this->seedTransactions($users, $clients);
        $this->seedClientServices($users, $clients);
    }

    private function seedUsers(): void
    {
        $employees = User::factory()->count(2)->create(['status' => UserStatus::Active]);
        $employees->each(fn (User $user) => $user->assignRole(RoleEnum::Employee->value));

        $admin = User::factory()->create(['status' => UserStatus::Active]);
        $admin->assignRole('admin');

        $pendingEmployee = User::factory()->create([
            'password' => null,
            'status' => UserStatus::Pending,
            'invitation_token' => Str::random(48),
        ]);
        $pendingEmployee->assignRole(RoleEnum::Employee->value);

        $bannedEmployee = User::factory()->create(['status' => UserStatus::Banned]);
        $bannedEmployee->assignRole(RoleEnum::Employee->value);
    }

    /**
     * @return Collection<int, Client>
     */
    private function seedClients()
    {
        $parents = Client::factory()->count(5)->create();
        $parents->each(fn (Client $parent) => Client::factory()->count(2)->create(['parent_id' => $parent->id]));

        Client::factory()->count(15)->create();

        return Client::all();
    }

    /**
     * @return Collection<int, Trip>
     */
    private function seedTrips()
    {
        Trip::factory()->count(8)->withPrices()->create();

        return Trip::all();
    }

    /**
     * @param  Collection<int, Trip>  $trips
     * @param  Collection<int, Client>  $clients
     */
    private function seedBookings($trips, $clients): void
    {
        foreach ($trips as $trip) {
            $tripClients = $clients->random(min(5, $clients->count()));

            foreach ($tripClients as $client) {
                $booking = Booking::factory()->create([
                    'client_id' => $client->id,
                    'trip_id' => $trip->id,
                ]);

                $booking->update([
                    'paid' => (int) round($booking->final_price * fake()->randomFloat(2, 0, 1)),
                ]);

                TripClient::create([
                    'client_id' => $client->id,
                    'trip_id' => $trip->id,
                    'booking_id' => $booking->id,
                    'room_type' => $booking->room_type,
                    'price' => $booking->price,
                    'discount_amount' => $booking->discount_amount,
                    'notes' => $booking->notes,
                ]);
            }
        }
    }

    /**
     * @param  Collection<int, User>  $users
     * @param  Collection<int, Client>  $clients
     */
    private function seedTransactions($users, $clients): void
    {
        foreach (range(1, 30) as $ignored) {
            Transaction::factory()->create([
                'user_id' => $users->random()->id,
                'client_id' => $clients->random()->id,
            ]);
        }

        $bookings = Booking::all();

        foreach ($bookings->random(min(15, $bookings->count())) as $booking) {
            Transaction::factory()->create([
                'user_id' => $users->random()->id,
                'client_id' => $booking->client_id,
                'transactionable_type' => Booking::class,
                'transactionable_id' => $booking->id,
                'about' => __('booking.singular_label'),
            ]);
        }
    }

    /**
     * @param  Collection<int, User>  $users
     * @param  Collection<int, Client>  $clients
     */
    private function seedClientServices($users, $clients): void
    {
        $services = collect();

        foreach ($clients->random(min(15, $clients->count())) as $client) {
            $services->push(ClientService::factory()->create(['client_id' => $client->id]));
        }

        foreach ($services->random(min(8, $services->count())) as $service) {
            Transaction::factory()->create([
                'user_id' => $users->random()->id,
                'client_id' => $service->client_id,
                'transactionable_type' => ClientService::class,
                'transactionable_id' => $service->id,
                'about' => $service->service_name,
            ]);
        }
    }
}
