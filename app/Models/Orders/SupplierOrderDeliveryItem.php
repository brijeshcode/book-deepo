<?php

namespace App\Models\Orders;

use App\Models\Setup\Book;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderDeliveryItem extends Model
{
    use HasFactory,SoftDeletes,Authorable;

    protected $fillable = ['supplier_order_delivery_id', 'supplier_order_item_id', 'book_id',  'quantity', 'unit_price', 'price', 'discount_percent', 'discount_total', 'price_total'];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
