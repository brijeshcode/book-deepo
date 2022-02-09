<?php

namespace App\Models\Setup;

use App\Models\Orders\SchoolOrder;
use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Models\Setup\Location;
use App\Models\Setup\Warehouse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'warehouse_id' , 'address', 'name', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'user_id', 'user_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
    public function books()
    {
        return $this->belongsToMany(Book::class);
        // return $this->hasMany(Book::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }
    public function orders()
    {
        return $this->hasMany(SchoolOrder::class);
    }
}
