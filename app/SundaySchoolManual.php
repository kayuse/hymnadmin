<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SundaySchoolManual extends Model
{
    //
    protected $fillable = [
        'name',
        'language',
        'user_id',
        'year'
    ];
    public function topics()
    {
        return $this->hasMany('App\SundaySchoolTopic', 'manual_id', 'id');
    }
}
