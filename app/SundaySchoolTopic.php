<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SundaySchoolTopic extends Model
{
    //
    public function podcast()
    {
        return $this->hasOne('App\Podcast', 'topic_id', 'id');
    }
}
