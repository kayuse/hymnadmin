<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{

    protected $fillable = ['topic_id', 'media'];

    //
    public function sundaySchoolTopic()
    {
        return $this->belongsTo('App\SundaySchoolTopic', 'topic_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\PodcastComment', 'podcast_id', 'id');
    }

    public function getMediaAttribute($value)
    {
        return 'https://' . strtolower(env('DO_REGION')) . '.digitaloceanspaces.com/' . env('DO_BUCKET') . '/' . $value;
    }

}
