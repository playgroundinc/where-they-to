<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    //

    protected $fillable = [
      'type'
    ];
    protected $attributes = array(
      'type' => '{}',
    );
}
