<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrder;
use App\Models\Setup\Book;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderDelivery extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['date', 'supplier_id', 'supplier_order_id', 'supplier_order_item_id',
    'school_order_id', 'school_order_item_id', 'book_id', 'quantity', 'unit_price' , 'price', 'user_id','user_ip'];

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
