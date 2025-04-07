<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $fillable = [
        'user_id','question_id','answer','result','exam_sitting_id'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

}
