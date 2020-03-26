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
    public function performers() {
      return $this->hasMany(Performer::class);
    }
    public function venues() {
      return $this->hasMany(Venue::class);
    }
    public function socialLinks() {
      return $this->hasOne(SocialLinks::class);
    }
    public function events() {
      return $this->hasMany(Event::class);
    }
    protected $fillable = [
      'password',
      'email',
      'type',
      'performers',
      'venues',
      'city',
      'region',
      'country',
      'timezone'
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
