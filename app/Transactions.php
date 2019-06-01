<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
     protected $guarded = [];
    protected $table = 'transactions';
    public $timestamps = false;
}
