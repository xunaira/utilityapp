<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $guarded = [];
    protected $table = 'report';
    public $timestamps = false;
}
