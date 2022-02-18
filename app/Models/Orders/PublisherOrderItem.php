<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherOrderDeliveryItem;
use App\Models\Setup\Book;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderItem extends Model
{
    use Authorable;
    use HasFactory,SoftDeletes;
    protected $fillable = ['publisher_order_id', 'school_order_item_id', 'book_id', 'quantity', 'quantity_recived' ];

    public function order()
    {
        return $this->belongsTo(PublisherOrder::class );
    }

    public function book()
    {
        return $this->belongsTo(Book::class );
    }

    public function delivery()
    {
        return $this->hasOne(PublisherOrderDeliveryItem::class);
    }
}
