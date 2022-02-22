<?php

namespace App\Traits;

use App\Models\User;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('name', 'id');
    }

}