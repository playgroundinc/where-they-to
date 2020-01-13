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
    protected $fillable = [
      'type',
      'name',
      'bio',
      'user_id',
      'family_id'
    ];
    protected $attributes = array(
      'type' => '{}',
    );
}
