<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    //
    protected $fillable = ['from_user','to_user'];
}
