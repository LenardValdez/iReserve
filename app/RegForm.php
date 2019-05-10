<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegForm extends Model
{    
    protected $fillable = [
        'stime_res',
        'etime_res',
        'purpose',
        'users_involved',
        'room_id',
        'user_id'
    ];

    protected $hidden = [
        'form_id',
        'updated_at',
        'isApproved',
        'isCancelled'
    ];

    protected $table ='reg_forms';
    //Primary Key
    public $primaryKey = 'form_id';
    //Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}