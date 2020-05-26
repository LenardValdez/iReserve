<?php

use Illuminate\Support\Facades\Log;
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
        Log::info('Seeding Users...');
        DB::table('users')->insert([
            [
                'user_id' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@iacademy.edu.ph',
                'password' => Hash::make('adminpassword'),
                'roles' => '0', //0=admin, 1=user, 2=security
                'user_type' => '1', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'security',
                'name' => 'Security Personnel',
                'email' => 'security@iacademy.edu.ph',
                'password' => Hash::make('secpassword'),
                'roles' => '2', //0=admin, 1=user, 2=security
                'user_type' => '1', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701054',
                'name' => 'Lenard Valdez',
                'email' => '201701054@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:01:23',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701026',
                'name' => 'Amiel Roseller II Saballo',
                'email' => '201701026@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:01:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701065',
                'name' => 'Janzon Jon Victorio',
                'email' => '201701065@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:02:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701051',
                'name' => 'Miqaela Nicole Banguilan',
                'email' => '201701051@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201702012',
                'name' => 'Nicole Kaye Bilon',
                'email' => '201702012@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701039',
                'name' => 'Rhej Christian Laurel',
                'email' => '201701039@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701068',
                'name' => 'Bryan Azley Novicio',
                'email' => '201701068@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701027',
                'name' => 'Dean Marcus Esturco',
                'email' => '201701027@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201601132',
                'name' => 'Aaron Gayle Kwek',
                'email' => '201601132@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701050',
                'name' => 'Joshua Miguel de Veyra',
                'email' => '201701050@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'marikit.valmadrid',
                'name' => 'Marikit Valmadrid',
                'email' => 'marikit.valmadrid@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'bennett.tanyag',
                'name' => 'Bennett Tanyag',
                'email' => 'bennett.tanyag@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'mitch.andaya',
                'name' => 'Mitch Andaya',
                'email' => 'mitch.andaya@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701061',
                'name' => 'Maurice Cesar Figueras',
                'email' => '201701061@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501008',
                'name' => 'Chlouie Nicole Villarta',
                'email' => '201501008@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'ronald.ramos',
                'name' => 'Ronald Ramos',
                'email' => 'ronald.ramos@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'riel.gomez',
                'name' => 'Riel Gomez',
                'email' => 'riel.gomez@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201503006',
                'name' => 'Janine Louise Arguelles',
                'email' => '201503006@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501193',
                'name' => 'Jearmayn Silleva',
                'email' => '201501193@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501029',
                'name' => 'Ma. Isabel Romero',
                'email' => '201501029@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701094',
                'name' => 'Titus Yorrick Madrideo',
                'email' => '201701094@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201601053',
                'name' => 'Matthew Vincent Montesa',
                'email' => '201601053@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501098',
                'name' => 'Shawn Frederich Uy',
                'email' => '201501098@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201601125',
                'name' => 'John Kesler Yung',
                'email' => '201601125@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701019',
                'name' => 'Joshua Manuel De Lara',
                'email' => '201701019@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201601117',
                'name' => 'Manuel Victorio Chua',
                'email' => '201601117@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201603007',
                'name' => 'William Boco',
                'email' => '201603007@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701076',
                'name' => 'Franco Mamaril',
                'email' => '201701076@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201601098',
                'name' => 'Sean Reinhold Mira',
                'email' => '201601098@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701106',
                'name' => 'Joshua Joseph Mayo',
                'email' => '201701106@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201403250',
                'name' => 'Tisha Janelle Esquejo',
                'email' => '201403250@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501018',
                'name' => 'Lois Bernadette Tagle',
                'email' => '201501018@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '4', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201501336',
                'name' => 'Rayne Shainnah Cordero',
                'email' => '201501336@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201701020',
                'name' => 'Hannah Chua',
                'email' => '201701020@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'juco.rivera',
                'name' => 'Juco Antonio Rivera',
                'email' => 'juco.rivera@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'ricky.deguzman',
                'name' => 'Ricky de Guzman',
                'email' => 'ricky.deguzman@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'victorino.villoria',
                'name' => 'Victorino Villoria',
                'email' => 'victorino.villoria@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => '201602002',
                'name' => 'Daryl Garth Pazziuagan',
                'email' => '201602002@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '3', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 'raymond.zalameda',
                'name' => 'Raymond Zalameda',
                'email' => 'raymond.zalameda@iacademy.edu.ph',
                'password' => Hash::make('userpassword'),
                'roles' => '1', //0=admin, 1=user, 2=security
                'user_type' => '2', //1=staff, 2=faculty, 3=college, 4=SHS
                'isActive' => true,
                'created_at' => '2019/05/03 11:00:00',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
        Log::info('Seeding completed.');
    }
}
