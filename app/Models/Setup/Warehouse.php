<?php

namespace App\Models\Setup;

use App\Models\Setup\Location;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'location_id' , 'name','address', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'user_id', 'user_ip'];

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

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
