<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    //
    public function events() {
      return $this->belongsToMany(Event::class);
    }

    protected $fillable = [
      'name',
    ];
}
