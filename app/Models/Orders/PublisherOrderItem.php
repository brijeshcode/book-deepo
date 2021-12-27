<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['publisher_id', 'order_id', 'book_id', 'class', 'subject' ,'quantity', 'actor_id','actor_ip'];

    public function order()
    {
        return $this->belongsTo(PublisherOrder::class, 'order_id' );
    }
}
