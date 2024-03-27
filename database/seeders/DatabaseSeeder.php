<?php

namespace Database\Seeders;

use App\Models\Auditor;
use App\Models\AuditingJob;
use App\Enums\AuditingJobs\Status;
use App\Enums\Auditors\Location;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 4; $i++) {
            Auditor::create([
                'name' => $faker->name,
                'location' => $faker->randomElement(Location::getLocations()),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            AuditingJob::create([
                'description' => $faker->sentence,
                'status' => Status::SCHEDULED,
            ]);
        }
    }
}
