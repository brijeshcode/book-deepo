<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderReturnItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['date', 'publisher_order_return_id', 'publisher_order_item_id', 'book_id', 'unit_price', 'quantity', 'price','user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }

    public function returns()
    {
        return $this->belongsTo(PublisherOrderReturn::class);
    }
}
