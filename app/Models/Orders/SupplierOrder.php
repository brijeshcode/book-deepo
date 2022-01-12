<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['date','supplier_id', 'school_id', 'school_order_id', 'status', 'quantity', 'amount', 'note', 'user_id', 'user_ip'];


    public function items()
    {
        return $this->hasMany(SupplierOrderItem::class);
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
