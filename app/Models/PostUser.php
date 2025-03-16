<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    protected $fillable = [
      'post_id',
      'user_id',
      'proxy',
      'proxy_phone',
      'phone',
      'payment',
      'full_name',
    ];
}
