<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSitting extends Model
{
    //

    public function exam() {
        return $this->belongsTo(Exam::class);
    }
}
