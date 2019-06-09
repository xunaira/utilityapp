<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard_name = 'web';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    function company()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    function agent()
    {
        return $this->hasOne('App\agents_migration','id','agent_id');
    }

   function target()
    {
        return $this->hasOne('App\Target','user_id','agent_id');
    }

   function sales()
    {
        return $this->hasMany('App\AgentSales','agent','agent_id')->where('status','Approved');
    }

}
