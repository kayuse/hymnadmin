<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    //
    protected $fillable = ['id', 'number', 'content', 'hymn_id'];
}
