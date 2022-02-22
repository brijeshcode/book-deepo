<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Orders\SupplierOrderReturn;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierChallan extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'school_order_id', 'supplier_delivery_id', 'supplier_order_id', 'supplier_id', 'date', 'delivery_id', 'return_id',  'challan_type', 'challan_no', 'amount', 'path', 'payment_status', 'note'];

    public function delivery()
    {
        return $this->belongsTo(SupplierOrderDelivery::class , 'delivery_id');
    }

    public function return()
    {
        return $this->belongsTo(SupplierOrderReturn::class , 'return_id');
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class, 'school_order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}