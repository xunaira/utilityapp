<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
   	protected $guarded = [];
    protected $table = 'balance';
    public $timestamps = false;
}
