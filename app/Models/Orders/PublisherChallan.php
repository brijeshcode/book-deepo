<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Orders\SchoolOrder;
use App\Models\Setup\Publisher;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherChallan extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;
    protected $fillable = [ 'school_order_id', 'publisher_order_id', 'publisher_id', 'delivery_id', 'return_id', 'date', 'challan_no', 'challan_type', 'amount', 'path', 'payment_status', 'note'];

    public function delivery()
    {
        return $this->belongsTo(PublisherOrderDelivery::class , 'delivery_id');
    }

    public function return()
    {
        return $this->belongsTo(PublisherOrderReturn::class , 'return_id');
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class, 'school_order_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
