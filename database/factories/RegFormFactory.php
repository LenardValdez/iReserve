<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\RegForm;
use App\Room;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(RegForm::class, function (Faker $faker) {
    $randomUsers =  User::where('roles', 1)->inRandomOrder()->take(6)->get();
    $randomUsers = $randomUsers->pluck('name')->toArray();
    return [
        'purpose' => $faker->sentence,
        'users_involved' => implode(', ', $randomUsers)
    ];
});

$factory->state(RegForm::class, 'admin', function (Faker $faker) {
    return [
        'user_id' => 'admin'
    ];
});

$factory->state(RegForm::class, 'faculty', function (Faker $faker) {
    return [
        'user_id' => User::where('user_type', 2)->get()->random()->user_id
    ];
});

$factory->state(RegForm::class, 'college', function (Faker $faker) {
    return [
        'user_id' => User::where('user_type', 3)->get()->random()->user_id
    ];
});

$factory->state(RegForm::class, 'seniorHigh', function (Faker $faker) {
    return [
        'user_id' => User::where('user_type', 4)->get()->random()->user_id
    ];
});

$factory->state(RegForm::class, 'specialRoom', function (Faker $faker) {
    return [
        'room_id' => Room::where('isSpecial', 1)->get()->random()->room_id
    ];
});

$factory->state(RegForm::class, 'normalRoom', function (Faker $faker) {
    return [
        'room_id' => Room::where('isSpecial', 0)->get()->random()->room_id
    ];
});

$factory->state(RegForm::class, 'approved', function (Faker $faker) {
    return [
        'isApproved' => 1
    ];
});

$factory->state(RegForm::class, 'rejected', function (Faker $faker) {
    return [
        'isApproved' => 2
    ];
});

$factory->state(RegForm::class, 'cancelled', function (Faker $faker) {
    return [
        'isCancelled' => true,
        'reasonCancelled' => $faker->sentence
    ];
});

$factory->state(RegForm::class, 'januaryWeek4', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 1, rand(27, 30), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 1, rand(27, 30), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 1, 27, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 1, 27, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'februaryWeek1', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 2, rand(3, 7), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 2, rand(3, 7), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 2, 3, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 2, 3, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'februaryWeek2', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 2, rand(11, 15), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 2, rand(11, 15), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 2, 10, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 2, 10, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'februaryWeek3', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 2, rand(17, 21), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 2, rand(17, 21), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 2, 17, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 2, 17, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'februaryWeek4', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 2, rand(24, 28), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 2, rand(24, 28), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 2, 24, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 2, 24, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'marchWeek1', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 3, rand(3, 7), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 3, rand(3, 7), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 3, 2, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 3, 2, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'marchWeek2', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 3, rand(10, 14), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 3, rand(10, 14), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 3, 9, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 3, 9, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'marchWeek3', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 3, rand(17, 21), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 3, rand(17, 21), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 3, 16, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 3, 16, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'marchWeek4', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 3, rand(23, 27), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 3, rand(23, 27), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 3, 23, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 3, 23, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'aprilWeek1', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 4, rand(1, 4), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 4, rand(1, 4), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 4, 1, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 4, 1, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'aprilWeek2', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 4, rand(6, 10), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 4, rand(6, 10), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 4, 6, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 4, 6, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'aprilWeek3', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 4, rand(14, 18), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 4, rand(14, 18), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 4, 13, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 4, 13, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'aprilWeek4', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 4, rand(21, 25), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 4, rand(21, 25), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 4, 20, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 4, 20, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'mayWeek1', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 5, rand(4, 8), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 5, rand(4, 8), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 5, 4, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 5, 4, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'mayWeek2', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 5, rand(11, 15), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 5, rand(11, 15), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 5, 11, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 5, 11, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'mayWeek3', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 5, rand(17, 23), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 5, rand(17, 23), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 5, 18, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 5, 18, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});

$factory->state(RegForm::class, 'mayWeek4', function(Faker $faker) {
    return [
        'stime_res' => Carbon::create(2020, 5, rand(25, 27), 0, 0, 0)->addHours(rand(8, 12))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'etime_res' => Carbon::create(2020, 5, rand(25, 27), 0, 0, 0)->addHours(rand(13, 20))->addMinutes(rand(1, 59))->format('Y-m-d H:i:s'),
        'created_at' => Carbon::create(2020, 5, 25, 0, 0, 0)->addHours(9)->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::create(2020, 5, 25, 0, 0, 0)->addHours(10)->format('Y-m-d H:i:s')
    ];
});