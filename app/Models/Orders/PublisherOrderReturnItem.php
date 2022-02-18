<?php

namespace App\Models\Orders;

use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderReturnItem extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;
    protected $fillable = ['date', 'publisher_order_return_id', 'publisher_order_item_id', 'book_id', 'unit_price', 'quantity', 'price'];

    public function returns()
    {
        return $this->belongsTo(PublisherOrderReturn::class);
    }
}
