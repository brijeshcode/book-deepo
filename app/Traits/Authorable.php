<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Authorable
{
    public static function bootAuthorable()
    {
        static::creating(function ($model) {
            if (empty($model->user_id)) {
                $model->user_id = auth()->id();
                $model->user_ip = request()->ip();
            }
        });
    }
}