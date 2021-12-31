<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['supplier_id', 'publisher_id', 'email', 'date', 'mobile', 'fax', 'contact_person', 'note', 'total_quantity', 'total_amount', 'actor_id', 'actor_ip'];

    public function items()
    {
        return $this->hasMany(SupplierOrderItem::class, 'order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
