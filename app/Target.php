<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded = [];
    protected $table = 'agent_target';
    public $timestamps = false;
}
