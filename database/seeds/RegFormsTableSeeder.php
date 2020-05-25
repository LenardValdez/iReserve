<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\RegForm;

class RegFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *            $table->string('form_id')->primary();
     * @return void
     */
    public function run()
    {
        // DB::table('reg_forms')->insert([
        //     [
        //         'form_id' => '00000003',
        //         'room_id' => '902',
        //         'user_id' => '201701054',
        //         'users_involved' => 'Amiel Roseller II Saballo, Janzon Jon Victorio', 
        //         'stime_res' => '2019-05-04 11:00:00',
        //         'etime_res' => '2019-05-04 12:00:00',
        //         'purpose' => 'SOFTEN Sprint',
        //         'isApproved' => '1', //0=pending, 1=approved, 2=rejected
        //         'isCancelled' => false,
        //         'created_at' => '2019-05-04 11:00:00',
        //         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        //     ]
        // ]);

        // 20 reservations for the 4th week of January 2020
        factory(RegForm::class, 3)->states('faculty', 'approved', 'specialRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 4)->states('faculty', 'approved', 'normalRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 4)->states('college', 'approved', 'specialRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 2)->states('college', 'approved', 'normalRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'normalRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'rejected', 'specialRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'rejected', 'cancelled', 'specialRoom', 'januaryWeek4')->create();
        factory(RegForm::class, 3)->states('admin', 'approved', 'specialRoom', 'januaryWeek4')->create();

        // 10 reservations for the 1st week of February 2020
        factory(RegForm::class, 1)->states('faculty', 'approved', 'normalRoom', 'februaryWeek1')->create();
        factory(RegForm::class, 2)->states('faculty', 'approved', 'specialRoom', 'februaryWeek1')->create();
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'februaryWeek1')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'normalRoom', 'februaryWeek1')->create();
        factory(RegForm::class, 2)->states('admin', 'approved', 'normalRoom', 'februaryWeek1')->create();

        // 15 reservations for the 2nd week of February 2020
        factory(RegForm::class, 4)->states('faculty', 'approved', 'normalRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 1)->states('faculty', 'approved', 'cancelled', 'normalRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 2)->states('college', 'approved', 'normalRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 1)->states('college', 'rejected', 'specialRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 1)->states('college', 'approved', 'cancelled', 'specialRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'normalRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'rejected', 'specialRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'approved', 'cancelled', 'specialRoom', 'februaryWeek2')->create();
        factory(RegForm::class, 2)->states('admin', 'approved', 'specialRoom', 'februaryWeek2')->create();

        // 9 reservations for the 3rd week of February 2020
        factory(RegForm::class, 4)->states('faculty', 'approved', 'specialRoom', 'februaryWeek3')->create();
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'februaryWeek3')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'approved', 'cancelled', 'normalRoom', 'februaryWeek3')->create();
        factory(RegForm::class, 1)->states('admin', 'approved', 'specialRoom', 'februaryWeek3')->create();

        // 10 reservations for the 4th week of February 2020
        factory(RegForm::class, 1)->states('faculty', 'approved', 'cancelled', 'normalRoom', 'februaryWeek4')->create();
        factory(RegForm::class, 2)->states('faculty', 'approved', 'specialRoom', 'februaryWeek4')->create();
        factory(RegForm::class, 4)->states('college', 'approved', 'normalRoom', 'februaryWeek4')->create();
        factory(RegForm::class, 3)->states('seniorHigh', 'approved', 'normalRoom', 'februaryWeek4')->create();

        // 5 reservations for the 1st week of March 2020
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'marchWeek1')->create();
        factory(RegForm::class, 2)->states('admin', 'approved', 'specialRoom', 'marchWeek1')->create();
        
        // 3 reservations for the 2nd week of March 2020
        factory(RegForm::class, 2)->states('college', 'approved', 'normalRoom', 'marchWeek2')->create();
        factory(RegForm::class, 1)->states('admin', 'approved', 'normalRoom', 'marchWeek2')->create();

        // 10 reservations for the 3rd week of March 2020
        factory(RegForm::class, 7)->states('faculty', 'approved', 'normalRoom', 'marchWeek3')->create();
        factory(RegForm::class, 3)->states('college', 'approved', 'specialRoom', 'marchWeek3')->create();

        // 9 reservations for the 4th week of March 2020
        factory(RegForm::class, 2)->states('college', 'approved', 'specialRoom', 'marchWeek4')->create();
        factory(RegForm::class, 1)->states('college', 'rejected', 'cancelled', 'specialRoom', 'marchWeek4')->create();
        factory(RegForm::class, 6)->states('seniorHigh', 'approved', 'normalRoom', 'marchWeek4')->create();

        // 9 reservations for the 1st week of April 2020
        factory(RegForm::class, 4)->states('faculty', 'approved', 'specialRoom', 'aprilWeek1')->create();
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'aprilWeek1')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'approved', 'cancelled', 'normalRoom', 'aprilWeek1')->create();
        factory(RegForm::class, 1)->states('admin', 'approved', 'specialRoom', 'aprilWeek1')->create();

        // 8 reservations for the 2nd week of March 2020
        factory(RegForm::class, 2)->states('faculty', 'approved', 'specialRoom', 'aprilWeek2')->create();
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'aprilWeek2')->create();
        factory(RegForm::class, 3)->states('seniorHigh', 'approved', 'specialRoom', 'aprilWeek2')->create();

        // 5 reservations for the 3rd week of March 2020
        factory(RegForm::class, 3)->states('college', 'approved', 'normalRoom', 'aprilWeek3')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'rejected', 'cancelled', 'specialRoom', 'aprilWeek3')->create();

        // 12 reservations for the 4th week of April 2020
        factory(RegForm::class, 3)->states('faculty', 'approved', 'specialRoom', 'aprilWeek4')->create();
        factory(RegForm::class, 2)->states('college', 'approved', 'specialRoom', 'aprilWeek4')->create();
        factory(RegForm::class, 4)->states('seniorHigh', 'approved', 'normalRoom', 'aprilWeek4')->create();
        factory(RegForm::class, 2)->states('admin', 'approved', 'specialRoom', 'aprilWeek4')->create();
        factory(RegForm::class, 1)->states('admin', 'approved', 'cancelled', 'specialRoom', 'aprilWeek4')->create();

        // 9 reservations for the 1st week of May 2020
        factory(RegForm::class, 3)->states('faculty', 'approved', 'specialRoom', 'mayWeek1')->create();
        factory(RegForm::class, 4)->states('college', 'approved', 'normalRoom', 'mayWeek1')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'cancelled', 'specialRoom', 'mayWeek1')->create();

        // 6 reservations for the 2nd week of May 2020
        factory(RegForm::class, 1)->states('faculty', 'approved', 'specialRoom', 'mayWeek2')->create();
        factory(RegForm::class, 2)->states('college', 'rejected', 'specialRoom', 'mayWeek2')->create();
        factory(RegForm::class, 3)->states('seniorHigh', 'approved', 'normalRoom', 'mayWeek2')->create();
    
        // 12 reservations for the 3rd week of May 2020
        factory(RegForm::class, 2)->states('faculty', 'approved', 'specialRoom', 'mayWeek3')->create();
        factory(RegForm::class, 1)->states('faculty', 'approved', 'cancelled', 'normalRoom', 'mayWeek3')->create();
        factory(RegForm::class, 2)->states('faculty', 'approved', 'normalRoom', 'mayWeek3')->create();
        factory(RegForm::class, 2)->states('college', 'approved', 'normalRoom', 'mayWeek3')->create();
        factory(RegForm::class, 2)->states('college', 'rejected', 'cancelled', 'normalRoom', 'mayWeek3')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'normalRoom', 'mayWeek3')->create();
        factory(RegForm::class, 1)->states('seniorHigh', 'approved', 'specialRoom', 'mayWeek3')->create();

        // 9 reservations for the 4th week of May 2020
        factory(RegForm::class, 3)->states('faculty', 'approved', 'specialRoom', 'mayWeek4')->create();
        factory(RegForm::class, 4)->states('college', 'approved', 'specialRoom', 'mayWeek4')->create();
        factory(RegForm::class, 2)->states('seniorHigh', 'approved', 'normalRoom', 'mayWeek4')->create();
    }
}