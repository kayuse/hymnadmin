<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSundaySchoolManual extends Model
{
    //
    protected $fillable = ['user_id', 'manual_id', 'copy'];

    public function manual()
    {
        return $this->belongsTo('App\SundaySchoolManual', 'manual_id', 'id');
    }
}
