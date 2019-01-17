<?php

namespace App\Entities;

use App\Traits\UuidPrimaryKey;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin.
 *
 * @package namespace App\Entities;
 */
class Admin extends Authenticatable implements Transformable
{
    use HasRoles;
    use Notifiable;
    use UuidPrimaryKey;
    use TransformableTrait;

    protected $guard_name = 'admin';
    
    protected $table = "admins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mobile', 'password', 'nickname', 'email', 'qq', 'status', 'verify_token', 'email_is_active'];

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
}
