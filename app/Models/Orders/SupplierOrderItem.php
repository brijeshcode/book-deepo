<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDeliveryItem;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderItem extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = ['supplier_order_id', 'school_order_item_id', 'book_id', 'quantity', 'quantity_recived'];

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function delivery()
    {
        return $this->hasOne(SupplierOrderDeliveryItem::class);
    }
}
