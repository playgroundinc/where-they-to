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
    public function family() 
    {
      return $this->belongsTo('App\Family');
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
