<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SundaySchoolTopic extends Model
{
    protected $fillable = [
        'category', 'topic', 'bible_text', 'aim', 'introduction', 'content', 'number', 'manual_id'
    ];

    //
    public function podcast()
    {
        return $this->hasOne('App\Podcast', 'topic_id', 'id');
    }

    public function escapedIntroduction()
    {
        $introduction = $this->introduction;
        return $introduction;

    }

    public function escapedContent()
    {
        $content = $this->content;
        return $content;
    }
}

