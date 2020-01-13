<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    //
    public function performer() {
      return $this->hasOne(Performer::class);
    }
    public function venue() {
      return $this->hasOne(Venue::class);
    }
    public function socialLinks() {
      return $this->hasOne(Venue::class);
    }
    protected $fillable = [
      'username',
      'password',
      'email',
      'type'
    ];
}
