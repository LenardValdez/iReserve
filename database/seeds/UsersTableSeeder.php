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
                'name' => 'Admin',
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
                'password' => bcrypt('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:01:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701026',
                'name' => 'Amiel Roseller II Saballo',
                'email' => '201701026@iacademy.edu.ph',
                'password' => bcrypt('userpassword2'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:01:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701065',
                'name' => 'Janzon Jon Victorio',
                'email' => '201701065@iacademy.edu.ph',
                'password' => bcrypt('userpassword3'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:02:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'marikit.valmadrid',
                'name' => 'Marikit Valmadrid',
                'email' => 'marikit.valmadrid@iacademy.edu.ph',
                'password' => bcrypt('userpassword4'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:03:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701065',
                'name' => 'Janzon Victorio',
                'email' => '201701065@iacademy.edu.ph',
                'password' => bcrypt('studentpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701026',
                'name' => 'Amiel Saballo',
                'email' => '201701026@iacademy.edu.ph',
                'password' => bcrypt('studentpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201702012',
                'name' => 'Nicole Bilon',
                'email' => '201702012@iacademy.edu.ph',
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
