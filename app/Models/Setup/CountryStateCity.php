<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryStateCity extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'name', 'parent_id', 'user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
}
