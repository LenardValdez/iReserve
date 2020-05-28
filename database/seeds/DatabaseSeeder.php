<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Log::info('Calling seeders...');
        $this->call(DivisionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(ClassScheduleSeeder::class);
        $this->call(RegFormsTableSeeder::class);
        Log::info('Database seeding completed.');
    }
}
