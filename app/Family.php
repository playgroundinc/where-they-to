<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    //
    public function performers() {
      return $this->hasMany(Performer::class);
    }
    public function socialLinks() {
      return $this->hasOne(SocialLinks::class);
    }
    public function events() {
      return $this->hasMany(Event::class);
    }
    protected $fillable = [
      'name',
      'description',
      'event_id'
    ];
}
