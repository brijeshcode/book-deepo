<?php

namespace App\Models\Setup;

use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Orders\SupplierOrderReturn;
use App\Models\Setup\Book;
use App\Models\Setup\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'location_id' , 'name', 'address', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'user_id', 'user_ip'];

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

    public function books()
    {
        // return $this->hasMany(Book::class);
        return $this->belongsToMany(Book::class);
    }

    public function orders()
    {
        return $this->hasMany(SupplierOrder::class);
    }

    public function deliveries()
    {
        return $this->hasMany(SupplierOrderDelivery::class);
    }

    public function challans()
    {
        return $this->hasMany(SupplierChallan::class);
    }

    public function returns()
    {
        return $this->hasMany(SupplierOrderReturn::class);
    }
}
