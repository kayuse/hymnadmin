<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    //
    public function sundaySchoolTopic()
    {
        return $this->belongsTo('App\SundaySchoolTopic', 'topic_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany('App\PodcastComment', 'podcast_id', 'id');
    }
}
