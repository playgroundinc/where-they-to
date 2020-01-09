<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    //

    protected $fillable = [
      'type',
      'name',
      'bio',
      'user'
    ];
    protected $attributes = array(
      'type' => '{}',
    );
}
