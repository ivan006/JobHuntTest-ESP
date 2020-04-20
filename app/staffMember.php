<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class staffMember extends Model
{

  public function images() {
    return $this->morphMany('App\image', 'parent');
  }
}
