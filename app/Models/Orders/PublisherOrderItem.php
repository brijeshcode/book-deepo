<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['publisher_order_id', 'school_order_item_id', 'book_id', 'quantity', 'status' , 'user_id','user_ip'];

    public function order()
    {
        return $this->belongsTo(PublisherOrder::class );
    }
}
