<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    //
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function family() 
    {
      return $this->belongsTo(Family::class);
    }

    public function socialLinks()
    {
      return $this->hasOne(socialLinks::class);
    }

    public function events() 
    {
      return $this->belongsToMany(Event::class);
    }

    public function performerTypes()
    {
      return $this->belongsToMany(PerformerType::class);
    }

    protected $fillable = [
      'name',
      'bio',
      'user_id',
      'family_id',
      'event_id',
      'tips',
    ];
}
