<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //

    public function audio() {
        return $this->hasMany(Audio::class);
    }
   
}
