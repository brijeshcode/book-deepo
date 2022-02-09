<?php

namespace App\Models\Orders;

use App\Models\Setup\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderDeliveryItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['supplier_order_delivery_id', 'supplier_order_item_id', 'book_id',  'quantity', 'unit_price', 'price', 'discount_percent', 'discount_total', 'price_total', 'user_id','user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
