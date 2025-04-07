<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
