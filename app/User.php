<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{ 
    use Notifiable;
    //
    public function performer() {
      return $this->hasOne(Performer::class);
    }
    public function venue() {
      return $this->hasOne(Venue::class);
    }
    public function socialLinks() {
      return $this->hasOne(SocialLinks::class);
    }
    protected $fillable = [
      'username',
      'password',
      'email',
      'type'
    ];

    protected $hidden = [
      'password', 'remember_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
