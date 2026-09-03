<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\PaymentMethod;
use App\Enums\RoleEnum;
use App\Enums\TransactionType;
use App\Enums\UserStatus;
use App\Models\Booking;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use App\Models\Branch;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Haj;
use App\Models\HajClient;
use App\Models\Omra;
use App\Models\OmraClient;
use App\Models\Salary;
use App\Models\SalaryLog;
use App\Models\Transaction;
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
        $branches = $this->seedBranches();

        if (Client::doesntExist()) {
            $this->seedUsers();

            $clients = $this->seedClients($branches);
            $omras = $this->seedOmras();
            $users = User::all();

            $this->seedBookings($omras, $clients, $branches, $users);
            $this->seedHajs($clients, $branches, $users);

            $this->seedTransactions($users, $clients, $branches);
            $this->seedClientServices($users, $clients);
        }

        $users ??= User::all();

        $this->seedSalaries($users);
        $this->seedBorrowings($users);
    }

    /**
     * @return Collection<int, Branch>
     */
    private function seedBranches()
    {
        if (Branch::doesntExist()) {
            Branch::factory()->count(4)->create();
        }

        return Branch::all();
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
     * @param  Collection<int, Branch>  $branches
     * @return Collection<int, Client>
     */
    private function seedClients($branches)
    {
        $parents = Client::factory()->count(5)->state(fn (): array => ['branch_id' => $branches->random()->id])->create();
        $parents->each(fn (Client $parent) => Client::factory()->count(2)->create([
            'parent_id' => $parent->id,
            'branch_id' => $parent->branch_id,
        ]));

        Client::factory()->count(15)->state(fn (): array => ['branch_id' => $branches->random()->id])->create();

        return Client::all();
    }

    /**
     * @return Collection<int, Omra>
     */
    private function seedOmras()
    {
        Omra::factory()->count(8)->withPrices()->create();

        return Omra::all();
    }

    /**
     * @param  Collection<int, Omra>  $omras
     * @param  Collection<int, Client>  $clients
     * @param  Collection<int, Branch>  $branches
     * @param  Collection<int, User>  $users
     */
    private function seedBookings($omras, $clients, $branches, $users): void
    {
        foreach ($omras as $omra) {
            $omraClients = $clients->random(min(5, $clients->count()));

            foreach ($omraClients as $client) {
                $booking = Booking::factory()->create([
                    'client_id' => $client->id,
                    'branch_id' => $branches->random()->id,
                    'bookable_type' => Omra::class,
                    'bookable_id' => $omra->id,
                ]);

                $this->seedBookingPayment($booking, $users);

                OmraClient::create([
                    'client_id' => $client->id,
                    'omra_id' => $omra->id,
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
     * @param  Collection<int, Client>  $clients
     * @param  Collection<int, Branch>  $branches
     * @param  Collection<int, User>  $users
     */
    private function seedHajs($clients, $branches, $users): void
    {
        $hajs = Haj::factory()->count(3)->active()->create();

        foreach ($hajs as $haj) {
            $hajClients = $clients->random(min(6, $clients->count()));
            $independentClients = [];

            foreach ($hajClients as $index => $client) {
                $booking = Booking::factory()->create([
                    'client_id' => $client->id,
                    'branch_id' => $branches->random()->id,
                    'bookable_type' => Haj::class,
                    'bookable_id' => $haj->id,
                    'price' => $haj->full_price,
                ]);

                $this->seedBookingPayment($booking, $users);

                $hajClient = HajClient::create([
                    'client_id' => $client->id,
                    'haj_id' => $haj->id,
                    'booking_id' => $booking->id,
                    'discount_amount' => $booking->discount_amount,
                    'dependency_type' => HajClientDependencyType::Independent,
                ]);

                // Every third client travels independently; the rest depend on the previous independent client.
                if ($index % 3 === 0) {
                    $independentClients[] = $hajClient;

                    continue;
                }

                if ($independentClients === []) {
                    continue;
                }

                $hajClient->update([
                    'dependency_type' => HajClientDependencyType::Dependent,
                    'depends_on_haj_client_id' => fake()->randomElement($independentClients)->id,
                    'relation_type' => fake()->randomElement(HajClientRelationType::cases()),
                ]);
            }
        }
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function seedBookingPayment(Booking $booking, $users): void
    {
        $amount = (int) round($booking->final_price * fake()->randomFloat(2, 0, 1));

        if ($amount <= 0) {
            return;
        }

        Transaction::create([
            'branch_id' => $booking->branch_id,
            'user_id' => $users->random()->id,
            'client_id' => $booking->client_id,
            'transactionable_type' => Booking::class,
            'transactionable_id' => $booking->id,
            'about' => __('booking.singular_label'),
            'amount' => $amount,
            'currency_code' => Currency::EGYPTIAN_POUND,
            'payment_method' => fake()->randomElement([PaymentMethod::CASH, PaymentMethod::BANK, PaymentMethod::VISA]),
            'type' => TransactionType::IN,
        ]);
    }

    /**
     * @param  Collection<int, User>  $users
     * @param  Collection<int, Client>  $clients
     * @param  Collection<int, Branch>  $branches
     */
    private function seedTransactions($users, $clients, $branches): void
    {
        foreach (range(1, 30) as $ignored) {
            Transaction::factory()->create([
                'user_id' => $users->random()->id,
                'client_id' => $clients->random()->id,
                'branch_id' => $branches->random()->id,
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

    /**
     * @param  Collection<int, User>  $users
     */
    private function seedSalaries($users): void
    {
        if (Salary::exists()) {
            return;
        }

        $staff = $users->filter(fn (User $user): bool => $user->isActive() && ! $user->isSuperAdmin())->take(3);

        foreach ($staff as $index => $user) {
            $user->update(['has_salary' => true]);

            $salary = Salary::factory()->create([
                'user_id' => $user->id,
                'started_at' => now()->subMonths(4),
            ]);

            foreach (range(3, 1) as $monthsAgo) {
                SalaryLog::factory()->create([
                    'salary_id' => $salary->id,
                    'paid_at' => now()->subMonths($monthsAgo),
                    'for_month' => now()->subMonths($monthsAgo)->startOfMonth(),
                ]);
            }

            if ($index === 0) {
                $salary->update(['ended_at' => now()->subMonth()]);
            }
        }
    }

    /**
     * @param  Collection<int, User>  $users
     */
    private function seedBorrowings($users): void
    {
        if (Borrowing::exists()) {
            return;
        }

        $staff = $users->filter(fn (User $user): bool => $user->isActive())->take(4);

        foreach ($staff as $index => $user) {
            $borrowing = Borrowing::factory()->create(['user_id' => $user->id]);

            // Every other borrowing gets a couple of repayment logs.
            if ($index % 2 !== 0) {
                continue;
            }

            $paid = 0;

            foreach ([1, 2] as $ignored) {
                $log = BorrowingLog::factory()->create([
                    'borrowing_id' => $borrowing->id,
                    'amount' => min($borrowing->amount - $paid, fake()->numberBetween(200, 1500)),
                ]);

                $paid += $log->amount;
            }

            $borrowing->update([
                'paid' => $paid,
                'remaining' => max(0, $borrowing->amount - $paid),
                'ended_at' => $paid >= $borrowing->amount ? now() : null,
            ]);
        }
    }
}
