<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegForm extends Model
{
    protected $fillable = [
        'stime_res',
        'etime_res',
        'purpose',
        'room_id',
    ];

    protected $hidden = [
        'form_id',
        'updated_at',
    ];

    protected $primaryKey = 'form_id';
}
