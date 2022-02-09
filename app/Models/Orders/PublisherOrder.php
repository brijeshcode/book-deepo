<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Setup\Publisher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'date' ,'amount', 'quantity', 'publisher_id', 'school_order_id', 'status','user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
    public function items()
    {
        return $this->hasMany(PublisherOrderItem::class);
    }

    public function deliveries()
    {
        return $this->hasMany(PublisherOrderDelivery::class);
    }

    public function challans()
    {
        return $this->hasMany(PublisherChallan::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class);
    }
}
