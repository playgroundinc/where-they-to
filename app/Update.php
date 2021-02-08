<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    //
    public function performer() {
      return $this->belongsTo(Performer::class);
    }
    public function venue() {
      return $this->belongsTo(Venue::class);
    }
    public function family() {
      return $this->belongsTo(Family::class);
    }
    public function event() {
      return $this->belongsTo(Event::class);
    }
    protected $fillable = [
      'update',
    ];
}
