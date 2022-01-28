<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierChallan extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'school_order_id', 'supplier_delivery_id', 'supplier_order_id', 'supplier_id', 'date', 'challan_no', 'amount', 'path', 'payment_status', 'note', 'user_id', 'user_ip'];

    public function delivery()
    {
        return $this->belongsTo(SupplierOrderDelivery::class , 'supplier_delivery_id');
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