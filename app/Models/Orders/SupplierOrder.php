<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrder extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = ['date','supplier_id', 'school_id', 'school_order_id', 'status', 'quantity', 'amount', 'note'];

    public function items()
    {
        return $this->hasMany(SupplierOrderItem::class);
    }


    public function deliveries()
    {
        return $this->hasMany(SupplierOrderDelivery::class);
    }

    public function challans()
    {
        return $this->hasMany(SupplierChallan::class);
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
