<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //

    public function sections() {
        return $this->hasMany(Section::class);
    }

    public function delete() {
        if (file_exists(public_path() . '/images/exams/' . $this->image)) {
            @unlink(public_path() . '/images/exams/' . $this->image);
        }
        parent::delete();
    }

    public function examSittings() {
        return $this->hasMany(ExamSitting::class);
    }

}
