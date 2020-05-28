<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table ='divisions';
    public $primaryKey = 'division_id';

    protected $hidden = [
    'division_id',
    'division_name'
    ];

    public function classschedule(){
    return $this->hasMany('App\ClassSchedule', 'division_id');
    }

    public function user(){
    return $this->hasMany('App\User', 'user_type');
    }
}
