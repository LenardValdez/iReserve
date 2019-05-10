<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $fillable = [
        'room_id', 'room_desc', 'isSpecial'
    ];

    protected $table ='rooms';
    //Primary Key
    public $primaryKey = 'room_id';
    //Timestamps
    public $timestamps = true;

    public function form(){
      return $this->belongsTo('App\User', 'user_id');
  }
}