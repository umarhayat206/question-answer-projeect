<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function questions()
    {
        return $this->hasMany('App\Question');
    
    }
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
    
    public function getUrlAttribute()
    {
        //return route('question.show',$this->id);

        return '#';

    }
    public function getAvatarAttribute()
    {
        $email = "someone@somewhere.com";
       
        $size = 25;
        return  "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) .  "&s=" . $size;

    }
}
