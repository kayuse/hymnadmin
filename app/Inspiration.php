<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspiration extends Model
{
    //

    protected $fillable = ['title', 'description', 'link'];

    public function inspirationDisplay()
    {
        return $this->hasMany(InspirationDisplay::class, 'inspiration_id');
    }
}
