<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCopy extends Model
{
    //
    protected $fillable = ['user_id', 'copy_reference', 'reference_id'];
}
