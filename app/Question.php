<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function audio() {
        return $this->hasMany(Audio::class);
    }

    public function checkFile() {
        return  \File::exists('images/questions/'.$this->image);
    }

    public function numberOfAudio() {
        return $this->audio()->count();
    }

    public function UserAnswer() {
        return $this->hasMany(UserAnswer::class);
    }
}
