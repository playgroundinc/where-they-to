<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    //
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function socialLinks()
    {
      return $this->hasOne(socialLinks::class);
    }

    public function events() {
      return $this->hasMany(Event::class);
    }
    protected $fillable = [
      'name',
      'description',
      'country',
      'province',
      'timezone',
      'city',
      'address',
      'user_id',
      'family_id',
      'accent_color',
    ];
}
