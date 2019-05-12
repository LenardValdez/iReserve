<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $table ='rooms';
  //Primary Key
  public $primaryKey = 'room_id';
  public $incrementing = false;
  //Timestamps
  public $timestamps = true;

  protected $fillable = [
    'room_id', 'room_desc', 'isSpecial'
  ];

    public function form(){
      return $this->belongsTo('App\Form', 'form_id');
  }
}