<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    //
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function performers() {
      return $this->belongsToMany(Performer::class);
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
