<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SerialNumber.
 *
 * @package namespace App\Entities;
 */
class SerialNumber extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['admin_id', 'agent_id', 'student_id', 'vip_id', 'number', 'is_senior', 'channel', 'status'];

    /**
     * 关联管理员详情表
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function admin()
    {
        return $this->belongsTo('App\Entities\Admin');
    }

    /**
     * 关联代理商详情表
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Entities\Agent');
    }

    /**
     * 关联学生详情表
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Entities\Student');
    }

    /**
     * 关联VIP序列号类型详情表
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function vip()
    {
        return $this->belongsTo('App\Entities\VipCard');
    }
}
