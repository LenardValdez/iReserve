<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RegForm extends Model
{    
    use Notifiable;

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
        'purpose'
    ];

    protected $hidden = [
        'form_id',
        'updated_at',
        'isApproved',
        'isCancelled'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}