<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    protected $fillable = [
        'school_id','activation_code',
    ];

    public function School() {
        return $this->belongsTo(School::class);
    }
    public function User() {
        return $this->hasOne(User::class, 'id','school_id');
    }
}
