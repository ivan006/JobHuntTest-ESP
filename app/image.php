<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
  protected $fillable = [
    'parent_id',
    'parent_type',
    'url',
  ];
  public function parent() {
    return $this->morphTo();
  }
}
