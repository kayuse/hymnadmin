<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodcastComment extends Model
{
    protected $table = 'podcast_comments';

    //
    public function podcast()
    {
        return $this->belongsTo('App\Podcast', 'podcast_id', 'id');
    }

}
