<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderReturnItem;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderReturn extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['date', 'supplier_id', 'supplier_order_id', 'quantity', 'amount' , 'user_id','user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }

    public function items()
    {
        return $this->hasMany(SupplierOrderReturnItem::class);
    }

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id' );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
