<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherOrderItem;
use App\Models\Setup\Publisher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'date' ,'amount', 'quantity', 'publisher_id', 'school_order_id', 'status','user_id', 'user_ip'];

    public function items()
    {
        return $this->hasMany(PublisherOrderItem::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function schoolOrder()
    {
        return $this->belongsTo(SchoolOrder::class);
    }
}
