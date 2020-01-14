<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformerType extends Model
{
  //
  public function performers() {
    return $this->belongsToMany(Performer::class);
  }
}
