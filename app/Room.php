<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $fillable = [
        'room_id', 'room_desc', 'isSpecial'
    ];
    
  protected $primaryKey = 'room_id';
}