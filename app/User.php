<?php

namespace App;

use Doctrine\DBAL\Driver\IBMDB2\DB2Connection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Kodeine\Acl\Traits\HasRole;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,  HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','rate','parent_id','account','status', 'last_name', 'email', 'mobile', 'password','company_name','company_email','company_address','registration_number','company_phone','marketed_by','cc_email','cc_phone','cc_address','current_plan', 'plan_expiry', 'qr_balance', 'code_prefix','check_password', 'company_logo','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function plan(){
        return $this->belongsTo('App\Models\Plans', 'current_plan');
    }
    public function agent(){
        return $this->belongsTo('App\User', 'parent_id');
    }

    public function childs(){
        return $this->hasMany('App\User', 'parent_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders(){
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function bids(){

        return $this->hasMany('App\Models\UserStat', 'user_id')->select(DB::raw('(sum(digit0)+sum(digit1)+sum(digit2)+sum(digit3)+sum(digit4)+sum(digit5)+sum(digit6)+sum(digit7)+sum(digit8)+sum(digit9)) as total, user_id'))->groupBy('user_stats.user_id');

    }

}
