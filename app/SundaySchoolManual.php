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



    public function isPaid($id)
    {
        $result = $this->userSundaySchoolManuals()->where('user_sunday_school_manuals.user_id', $id)->where('user_sunday_school_manuals.manual_id', $this->id)->first();
        return $result != null;
    }

    public function userSundaySchoolManuals()
    {
        return $this->hasMany('App\UserSundaySchoolManual', 'manual_id', 'id');
    }
}
