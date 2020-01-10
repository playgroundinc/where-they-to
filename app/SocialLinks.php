<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    //
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    protected $fillable = [
      'twitter',
      'facebook',
      'instagram',
      'website',
      'youtube',
      'user_id'
    ];
}
