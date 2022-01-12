<?php

namespace App\Models\Orders;

use App\Models\Setup\Publisher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderDelivery extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['date', 'publisher_id', 'publisher_order_id', 'publisher_order_item_id', 'school_order_id', 'school_order_item_id','book_id', 'quantity', 'unit_price', 'price'];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
