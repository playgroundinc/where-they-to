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
    protected $fillable = [
      'type',
      'name',
      'bio',
      'user_id'
    ];
    protected $attributes = array(
      'type' => '{}',
    );
}
