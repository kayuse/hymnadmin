<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SundaySchoolManual extends Model
{
    //
    public function topics()
    {
        return $this->hasMany('App\SundaySchoolTopic', 'manual_id', 'id');
    }
}
