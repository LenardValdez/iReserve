<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
  use SoftDeletes;

  protected $table ='rooms';
  //Primary Key
  public $primaryKey = 'room_id';
  public $incrementing = false;
  //Timestamps
  public $timestamps = true;

  protected $fillable = [
    'room_id', 
    'room_name', 
    'room_desc', 
    'isSpecial'
  ];

  protected $hidden = [
    'updated_at',
    'deleted_at'
];

  public function regform(){
    return $this->hasMany('App\RegForm', 'room_id');
  }

  public function class(){
    return $this->hasMany('App\ClassSchedule', 'room_id');
  }
}