<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advert extends Model
{
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
