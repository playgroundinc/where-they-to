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
    public function eventType() 
    {
      return $this->belongsTo(EventType::class);
    }

    public function tickets()
    {
      return $this->belongsToMany(Ticket::class);
    }

    protected $fillable = [
      'name',
      'description',
      'date',
      'time',
      'type',
      'timezone'
    ];
  

}
