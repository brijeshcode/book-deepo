<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Orders\SupplierOrderReturn;
use App\Models\Orders\SupplierPayment;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrder extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = ['date','supplier_id', 'school_id', 'school_order_id', 'status', 'quantity', 'amount'];

    protected $appends = [
        'due',
        'paid',
        // 'delivery_total',
        // 'return_total',

        'return_challan_total',
        'delivery_challan_total',
    ];


    public function getDeliveryChallanTotalAttribute()
    {
        $total = 0;
        foreach ($this->challans as $key => $challan) {
            $total +=  $challan->challan_type == 'delivery' ? $challan->amount : 0;
        };
        return $total;
    }

    public function getReturnChallanTotalAttribute()
    {
        $total = 0;
        foreach ($this->challans as $key => $challan) {
            $total +=  $challan->challan_type == 'return' ? $challan->amount : 0;
        };
        return $total;
    }

    public function getDueAttribute()
    {
        return $this->delivery_challan_total - $this->return_challan_total - $this->paid;
    }

    public function getPaidAttribute()
    {
        $total = 0;
        foreach ($this->payments as $key => $payment) {
            $total +=  $payment->amount ;
        };
        return $total;
    }

    /*public function getDeliveryTotalAttribute()
    {
        $deliveryTotal = 0;
        foreach ($this->deliveries as $key => $delivery) {
            $deliveryTotal += $delivery->total_amount;
        }
        return $deliveryTotal;
    }

    public function getReturnTotalAttribute()
    {
        $returnTotal = 0;
        foreach ($this->returns as $key => $returns) {
            $returnTotal += $returns->amount;
        }
        return $returnTotal;
    }*/

    public function items()
    {
        return $this->hasMany(SupplierOrderItem::class);
    }


    public function deliveries()
    {
        return $this->hasMany(SupplierOrderDelivery::class);
    }

    public function returns()
    {
        return $this->hasMany(SupplierOrderReturn::class);
    }

    public function challans()
    {
        return $this->hasMany(SupplierChallan::class);
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
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
