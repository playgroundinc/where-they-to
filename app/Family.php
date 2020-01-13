<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    //
    public function performers() {
      return $this->hasMany('App\Performer');
    }
    public function socialLinks() {
      return $this->hasOne('App\SocialLinks');
    }
    protected $fillable = [
      'name',
      'description'
    ];
}
