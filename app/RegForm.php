<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegForm extends Model
{    

    protected $table ='reg_forms';
    //Primary Key
    public $primaryKey = 'form_id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'room_id',
        'users_involved',
        'stime_res',
        'etime_res',
        'reasonCancelled',
        'purpose'
    ];

    protected $hidden = [
        'form_id',
        'updated_at',
        'isApproved',
        'isCancelled'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function room(){
        return $this->belongsTo('App\Room', 'room_id');
    }
}