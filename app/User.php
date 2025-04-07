<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','exam_id','language_id', 'email', 'password','fname','lname','phone','gender','dob','token','mac_address','type','school_name','parent_id','expiry_date','name_of_register','profession_of_the_trainee','type_of_driving_license'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subUsers() {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function Language(){
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function ActivationCode() {
        return $this->belongsTo(ActivationCode::class,'token','activation_code');
    }
    
}
