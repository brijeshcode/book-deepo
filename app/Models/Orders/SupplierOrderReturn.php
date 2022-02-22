<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderReturnItem;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderReturn extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = ['date', 'supplier_id', 'supplier_order_id', 'quantity', 'amount'];

    public function items()
    {
        return $this->hasMany(SupplierOrderReturnItem::class);
    }

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id' );
    }

    public function challans()
    {
        return $this->hasMany(SupplierChallan::class, 'return_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
