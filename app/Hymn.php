<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hymn extends Model
{
    //
    protected $fillable = [
        'title',
        'number',
        'extra',
        'chorus',
        'user_id'
    ];

    public function verses()
    {
        return $this->hasMany('\App\Verse');
    }

    public function media()
    {
        return $this->hasMany('App\HymnMedia');
    }
}
