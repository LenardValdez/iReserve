<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'room_id' => '901',
                'room_desc' => '9th Floor',
                'isAvailable' => true,
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '902',
                'room_desc' => '9th Floor',
                'isAvailable' => true,
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:01:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '903',
                'room_desc' => '9th Floor',
                'isAvailable' => true,
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:02:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '904',
                'room_desc' => '9th Floor',
                'isAvailable' => true,
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:03:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '905',
                'room_desc' => '9th Floor',
                'isAvailable' => true,
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1001',
                'room_desc' => 'CL 10th Floor',
                'isAvailable' => true,
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:05:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
