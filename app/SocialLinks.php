<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    //
    public function venue()
    {
      return $this->belongsTo(Venue::class);
    }
    public function performer()
    {
      return $this->belongsTo(Performer::class);
    }
    public function family() 
    {
      return $this->belongsTo(Family::class);
    }
    public function event() 
    {
      return $this->belongsTo(Event::class);
    }
    protected $fillable = [
      'tiktok',
      'twitter',
      'facebook',
      'instagram',
      'website',
      'twitch',
      'youtube',
      'user_id',
      'event_id',
      'family_id'
    ];
}
