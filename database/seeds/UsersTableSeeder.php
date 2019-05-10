<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'user_id' => 'admin',
                'name' => 'Lerma Pantorilla',
                'email' => 'admin@iacademy.edu.ph',
                'password' => bcrypt('adminpassword'),
                'roles' => '0', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701054',
                'name' => 'Lenard Valdez',
                'email' => '201701054@iacademy.edu.ph',
                'password' => bcrypt('studentpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'security',
                'name' => 'Security Personnel',
                'email' => 'security@iacademy.edu.ph',
                'password' => bcrypt('secpassword'),
                'roles' => '2', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
