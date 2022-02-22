<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrderReturnItem;
use App\Models\Setup\Publisher;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherOrderReturn extends Model
{
    use Authorable;
    use HasFactory,SoftDeletes;
    protected $fillable = ['date', 'publisher_id', 'publisher_order_id', 'quantity', 'amount', 'note'];

    public function items()
    {
        return $this->hasMany(PublisherOrderReturnItem::class);
    }

    public function challans()
    {
        return $this->hasMany(PublisherChallan::class, 'return_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
