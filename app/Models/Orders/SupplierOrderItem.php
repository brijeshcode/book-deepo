<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrder;
use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['supplier_order_id', 'school_order_item_id', 'book_id', 'quantity', 'status'     , 'user_id','user_ip'];

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
}
