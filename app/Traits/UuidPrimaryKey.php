<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait UuidPrimaryKey
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->guid = Uuid::uuid4()->toString();
        });
    }
}