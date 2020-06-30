<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodcastComment extends Model
{
    public $fillable = [
        'user_id',
        'podcast_id',
        'text'
    ];
    protected $table = 'podcast_comments';

    //

    public function podcast()
    {
        return $this->belongsTo('App\Podcast', 'podcast_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
