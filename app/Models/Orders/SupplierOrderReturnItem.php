<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrderReturn;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderReturnItem extends Model
{
    use HasFactory,SoftDeletes,Authorable;

    protected $fillable = ['date', 'supplier_order_return_id', 'supplier_order_item_id', 'book_id', 'unit_price', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(SupplierOrderReturn::class );
    }
/*
    public function order()
    {
        return $this->belongsTo(SupplierOrder::class );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }*/

}
