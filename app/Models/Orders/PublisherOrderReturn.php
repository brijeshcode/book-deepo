<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherOrderReturnItem;
use App\Models\Setup\Publisher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderReturn extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['date', 'publisher_id', 'publisher_order_id', 'quantity', 'amount','user_id', 'user_ip'];

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
        return $this->hasMany(PublisherOrderReturnItem::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
