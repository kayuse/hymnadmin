<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HymnDownload extends Model
{
    //
    protected $fillable = ['number', 'version', 'file'];

    protected $table = 'hymn_downloads';
}
