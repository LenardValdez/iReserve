<?php

use Illuminate\Database\Seeder;

class ClassScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_schedules')->insert([
            [
                'subject_code' => 'ADVAPRO',
                'user_id' => 'bennett.tanyag',
                'room_id' => '1002',
                'section' => 'SEG-IR', 
                'stime_class' => '11:00:00',
                'etime_class' => '14:30:00',
                'day' => 'T',
                'division_id' => 3, // 3=college, 4=seniorHigh
                'term_number' => 3,
                'sdate_term' => '2020-03-01',
                'edate_term' => '2020-07-01',
                'created_at' => '2020-02-14 11:00:00',
                'updated_at' => '2020-02-14 11:00:00'
            ],
            [
                'subject_code' => 'OBJPROG',
                'user_id' => 'bennett.tanyag',
                'room_id' => '1002',
                'section' => 'SEG12', 
                'stime_class' => '11:00:00',
                'etime_class' => '14:30:00',
                'day' => 'F',
                'division_id' => 3, // 3=college, 4=seniorHigh
                'term_number' => 3,
                'sdate_term' => '2020-03-01',
                'edate_term' => '2020-07-01',
                'created_at' => '2020-02-14 11:00:00',
                'updated_at' => '2020-02-14 11:00:00'
            ],
            [
                'subject_code' => 'SFLECT218',
                'user_id' => 'riel.gomez',
                'room_id' => '1002',
                'section' => 'SEG41', 
                'stime_class' => '14:30:00',
                'etime_class' => '18:00:00',
                'day' => 'TH',
                'division_id' => 3, // 3=college, 4=seniorHigh
                'term_number' => 3,
                'sdate_term' => '2020-03-01',
                'edate_term' => '2020-07-01',
                'created_at' => '2020-02-14 11:00:00',
                'updated_at' => '2020-02-14 11:00:00'
            ],
            [
                'subject_code' => 'CSELEC06',
                'user_id' => 'bennett.tanyag',
                'room_id' => '1003',
                'section' => 'SEG31', 
                'stime_class' => '14:30:00',
                'etime_class' => '18:00:00',
                'day' => 'M',
                'division_id' => 3, // 3=college, 4=seniorHigh
                'term_number' => 3,
                'sdate_term' => '2020-03-01',
                'edate_term' => '2020-07-01',
                'created_at' => '2020-02-14 11:00:00',
                'updated_at' => '2020-02-14 11:00:00'
            ],
            [
                'subject_code' => 'DISMATH',
                'user_id' => 'victorino.villoria',
                'room_id' => '901',
                'section' => 'GDV22', 
                'stime_class' => '07:30:00',
                'etime_class' => '11:00:00',
                'day' => 'S',
                'division_id' => 3, // 3=college, 4=seniorHigh
                'term_number' => 3,
                'sdate_term' => '2020-03-01',
                'edate_term' => '2020-07-01',
                'created_at' => '2020-02-14 11:00:00',
                'updated_at' => '2020-02-14 11:00:00'
            ]
        ]);
    }
}
