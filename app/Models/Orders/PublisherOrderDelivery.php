<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrderDeliveryItem;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderDelivery extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;
    protected $fillable = ['date', 'publisher_id', 'school_id', 'publisher_order_id', 'school_order_id',  'quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount', 'payment_status', 'amount', 'note'];

    public function items()
    {
        return $this->hasMany(PublisherOrderDeliveryItem::class);
    }
    public function challans()
    {
        return $this->hasMany(PublisherChallan::class, 'publisher_delivery_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
