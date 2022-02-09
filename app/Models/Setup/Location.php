<?php

namespace App\Models\Setup;

use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'name', 'city', 'state', 'pincode', 'note', 'active', 'user_id', 'user_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
    public function publishers()
    {
        return $this->hasMany(Publisher::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
