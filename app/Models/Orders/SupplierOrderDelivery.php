<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDeliveryItem;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderDelivery extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = ['date', 'supplier_id', 'school_id', 'supplier_order_id', 'school_order_id',  'quantity', 'discount_percent', 'payment_status', 'discount', 'sub_total', 'total_amount', 'amount'];

    public function items()
    {
        return $this->hasMany(SupplierOrderDeliveryItem::class );
    }

    public function challans()
    {
        return $this->hasMany(SupplierChallan::class, 'supplier_delivery_id');
    }
    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id' );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
