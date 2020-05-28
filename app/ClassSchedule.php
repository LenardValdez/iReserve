<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table ='class_schedules';
    //Primary Key
    public $primaryKey = 'class_id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        'subject_code',
        'user_id',
        'room_id',
        'section',
        'stime_class',
        'etime_class',
        'day',
        'division_id',
        'term_number',
        'sdate_term',
        'edate_term'
    ];

    protected $hidden = [
        'class_id',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function division() {
        return $this->belongsTo('App\Division', 'division_id');
    }
}
