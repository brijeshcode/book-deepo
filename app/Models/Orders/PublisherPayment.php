<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherPayment extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;

    protected $fillable = [ 'publisher_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note'];

    public function challan()
    {
        return $this->belongsTo(PublisherChallan::class , 'challan_id');
    }

}
