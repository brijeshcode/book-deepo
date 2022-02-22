<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Orders\PublisherPayment;
use App\Models\Setup\Publisher;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrder extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;

    protected $fillable = [ 'date' ,'amount', 'quantity', 'publisher_id', 'school_order_id', 'status'];

    protected $appends = [
        'due',
        'paid',
        // 'delivery_total',
        // 'return_total',

        'return_challan_total',
        'delivery_challan_total',
    ];


    public function getDeliveryChallanTotalAttribute()
    {
        $total = 0;
        foreach ($this->challans as $key => $challan) {
            $total +=  $challan->challan_type == 'delivery' ? $challan->amount : 0;
        };
        return $total;
    }

    public function getReturnChallanTotalAttribute()
    {
        $total = 0;
        foreach ($this->challans as $key => $challan) {
            $total +=  $challan->challan_type == 'return' ? $challan->amount : 0;
        };
        return $total;
    }

    public function getDueAttribute()
    {
        return $this->delivery_challan_total - $this->return_challan_total - $this->paid;
    }

    public function getPaidAttribute()
    {
        $total = 0;
        foreach ($this->payments as $key => $payment) {
            $total +=  $payment->amount;
        };
        return $total;
    }

    public function items()
    {
        return $this->hasMany(PublisherOrderItem::class);
    }

    public function deliveries()
    {
        return $this->hasMany(PublisherOrderDelivery::class);
    }

    public function returns()
    {
        return $this->hasMany(PublisherOrderReturn::class);
    }

    public function challans()
    {
        return $this->hasMany(PublisherChallan::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function payments()
    {
        return $this->hasMany(PublisherPayment::class);
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class);
    }
}
