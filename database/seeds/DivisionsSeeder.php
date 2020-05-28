<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::info('Seeding Divisions...');

        DB::table('divisions')->insert([
            [
                'division_id' => '1',
                'division_name' => 'Administrator'
            ],
            [
                'division_id' => '2',
                'division_name' => 'Faculty'
            ],
            [
                'division_id' => '3',
                'division_name' => 'College'
            ],
            [
                'division_id' => '4',
                'division_name' => 'Senior High'
            ]
        ]);

        Log::info('Seeding completed.');
    }
}
