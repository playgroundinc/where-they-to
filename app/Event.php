<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    public function user() {
      return $this->belongsTo(User::class);
    }
    public function venue() 
    {
      return $this->belongsTo(Venue::class);
    }

    public function performers() 
    {
      return $this->belongsToMany(Performer::class);
    }

    public function family() 
    {
      return $this->belongsTo(Family::class);
    }

    public function socialLinks() 
    {
      return $this->hasOne(SocialLinks::class);
    }
    public function eventTypes() 
    {
      return $this->belongsToMany(EventType::class);
    }

    public function updates() {
      return $this->hasMany(Update::class);
    }

    protected $fillable = [
      'accent_color',
      'name',
      'address',
      'city',
      'doors',
      'province',
      'timezone',
      'description',
      'date',
      'show_time',
      'type',
      'tickets',
      'tickets_url'
    ];
  

}
