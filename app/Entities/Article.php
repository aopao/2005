<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Article.
 *
 * @package namespace App\Entities;
 */
class Article extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['admin_id', 'agent_id', 'article_category_id', 'source_id', 'title', 'excerpt', 'thumb', 'content', 'views', 'is_top', 'is_remark', 'http_url', 'status'];
}
