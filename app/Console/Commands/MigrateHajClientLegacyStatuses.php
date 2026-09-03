<?php

namespace App\Console\Commands;

use App\Enums\HajClientStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateHajClientLegacyStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-haj-client-legacy-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill haj_clients.status values from the retired pending/chosen statuses to their no_show/successful replacements.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $noShowCount = DB::table('haj_clients')->where('status', 'pending')->update(['status' => HajClientStatus::NoShow->value]);
        $successfulCount = DB::table('haj_clients')->where('status', 'chosen')->update(['status' => HajClientStatus::Successful->value]);

        $this->info("Updated {$noShowCount} row(s) from 'pending' to '".HajClientStatus::NoShow->value."'.");
        $this->info("Updated {$successfulCount} row(s) from 'chosen' to '".HajClientStatus::Successful->value."'.");
    }
}
