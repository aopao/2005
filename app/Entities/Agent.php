<?php

namespace App\Entities;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Agent.
 *
 * @package namespace App\Entities;
 */
class Agent extends Authenticatable implements JWTSubject, Transformable
{
    use HasRoles;
    use Notifiable;
    use TransformableTrait;

    /**
     * 设置 JWt guard
     *
     * @var string
     */
    protected $guard_name = 'agent';

    /**
     * 设置数据库表
     *
     * @var string
     */
    protected $table = "agents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mobile', 'password', 'nickname', 'rebates', 'email', 'qq', 'status', 'verify_token', 'email_is_active'];

    /**
     * 隐藏的字段
     *
     * @var array
     */
    protected $hidden = ['password', 'verify_token', 'email_is_active', 'remember_token'];

    /**
     * 密码加密
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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
}
