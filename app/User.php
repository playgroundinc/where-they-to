<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    //
    public function performer() {
      return $this->hasOne('App\Performer');
    }
    public function venue() {
      return $this->hasOne('App\Venue');
    }
    public function socialLinks() {
      return $this->hasOne('App\SocialLinks');
    }
    protected $fillable = [
      'username',
      'password',
      'email'
    ];
    protected $attributes = array(
      'events' => '{}',
    );
}
