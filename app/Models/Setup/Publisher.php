<?php

namespace App\Models\Setup;

use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Setup\Book;
use App\Models\Setup\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'location_id' , 'name', 'address', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'user_id', 'user_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function deliveries()
    {
        return $this->hasMany(PublisherOrderDelivery::class);
    }

    public function orders()
    {
        return $this->hasMany(PublisherOrder::class);
    }

    public function challans()
    {
        return $this->hasMany(PublisherChallan::class);
    }

    public function returns()
    {
        return $this->hasMany(PublisherOrderReturn::class);
    }
}
