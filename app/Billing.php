<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $guarded = [];
    protected $table = 'billing';
    public $timestamps = false;
}
