<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Province.
 *
 * @package namespace App\Entities;
 */
class RoleHasPermission extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'role_has_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
