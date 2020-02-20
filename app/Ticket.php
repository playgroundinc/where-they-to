<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    public function events() 
    {
      return $this->belongsToMany(Event::class);
    }

    protected $fillable = [
      'price',
      'description',
      'url'
    ];
}
