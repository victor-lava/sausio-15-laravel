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
        'name', 'email', 'password', 'gravatar_url', 'location', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token'
    ];

    public function statistic() {
        return $this->hasOne('App\Statistic');
    }

    public function histories() {
        return $this->hasMany('App\History');
    }

    public function generateKey() {
      do{
         $this->token = str_random(60);
      }
      while($this->where('token', $this->token)->exists());

      $this->save();
    }
}
