<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HymnMedia extends Model
{
    //
    public function url(){
        return $this->media;
    }
}
