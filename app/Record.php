<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $fillable = [
        'title', 'number', 'extra', 'data', 'user_id'
    ];
}
