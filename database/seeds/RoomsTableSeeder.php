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
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '902',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:01:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '903',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:02:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '904',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:03:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '905',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '906',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '907',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '908',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '909',
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'Cintiq Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'MMA 1',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'MMA 2',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'MMA 3',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'CL1',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'CL2',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'Lightbox Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'iMAC Lab',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => ' Drawing Room 1',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => ' Drawing Room 2',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => ' Drawing Room 3',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'PE Room 1',
                'room_desc' => '10th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'PE Room 2',
                'room_desc' => '10th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1009',
                'room_desc' => '10th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '801',
                'room_desc' => '8th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '802',
                'room_desc' => '8th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'Multimedia Lab 3	',
                'room_desc' => '8th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '701',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '702',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'Cintique Lab',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '704',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'SHS Drawing Room',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'SHS Science Lab',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '707',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '708',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '709',
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '601',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '602',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '603',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '604',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '605',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '606',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '607',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '608',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '609',
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'Main Reception',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'West Wing Waiting Area',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'East Wing Waiting Area',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
