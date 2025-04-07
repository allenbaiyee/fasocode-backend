<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    //
    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function checkFile() {
        return  \File::exists('audio/'.$this->file);
    }
}
