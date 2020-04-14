<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $fillable = ['mobile', 'dcc', 'lcb', 'language'];
    //
    /**
     *User Details model
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }
}
