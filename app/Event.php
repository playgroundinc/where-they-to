<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
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

    protected $fillable = [
      'name',
      'description',
      'date',
      'type'
    ];
}
