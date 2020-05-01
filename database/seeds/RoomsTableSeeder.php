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
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '902',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:01:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '903',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:02:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '904',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:03:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '905',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '906',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '907',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '908',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '909',
                'room_name' => null,
                'room_desc' => '9th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1001',
                'room_name' => 'Cintiq Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1002',
                'room_name' => 'MMA 1',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1003',
                'room_name' => 'MMA 2',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1004',
                'room_name' => 'MMA 3',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1005',
                'room_name' => 'CL1',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1006',
                'room_name' => 'CL2',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1007',
                'room_name' => 'Lightbox Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1008',
                'room_name' => 'iMAC Lab',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1009',
                'room_name' => 'MMA4 - New Wacom Cintiq Lab',
                'room_desc' => '10th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1010',
                'room_name' => 'Drawing Room 1 - Wet Drawing Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1011',
                'room_name' => 'Drawing Room 2 - Dry Drawing Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1012',
                'room_name' => 'Drawing Room 3 - Dry Drawing Room',
                'room_desc' => '10th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '1013',
                'room_name' => 'MMA5',
                'room_desc' => '10th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '801',
                'room_name' => null,
                'room_desc' => '8th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '802',
                'room_name' => null,
                'room_desc' => '8th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '803',
                'room_name' => 'SHS Multimedia Lab 1',
                'room_desc' => '8th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '701',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '702',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '703',
                'room_name' => 'Cintiq Lab',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '704',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '705',
                'room_name' => 'SHS Drawing Room',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '706',
                'room_name' => 'SHS Science Lab',
                'room_desc' => '7th Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '707',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '708',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '709',
                'room_name' => null,
                'room_desc' => '7th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '601',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '602',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '603',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '604',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '605',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '606',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '607',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '608',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => '609',
                'room_name' => null,
                'room_desc' => '6th Floor',
                'isSpecial' => false,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'GF',
                'room_name' => 'Lobby',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'GFWEST',
                'room_name' => 'West Wing Lobby',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'room_id' => 'GFEAST',
                'room_name' => 'East Wing Lobby',
                'room_desc' => 'Ground Floor',
                'isSpecial' => true,
                'created_at' => '2019/05/03 11:04:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
