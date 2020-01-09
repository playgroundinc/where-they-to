<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    //
    // public function performer() {
    //   return $this->hasOne('App\Performer', 'user');
    // }
    public function venue() {
      return $this->hasOne('App\Venue');
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
