<?php

namespace App\Models\Orders;

use App\Models\Setup\Publisher;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherPayment extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;

    protected $fillable = [ 'publisher_id', 'publisher_order_id', 'date', 'payment_mode', 'amount', 'note'];


    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'publisher_order_id');
    }

}
