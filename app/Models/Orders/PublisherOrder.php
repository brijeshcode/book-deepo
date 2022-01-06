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
    protected $fillable = [ 'publisher_id' , 'email', 'date', 'mobile', 'fax' ,'contact_person',  'note', 'total_quantity','total_amount','user_id', 'user_ip'];

    public function items()
    {
        return $this->hasMany(PublisherOrderItem::class, 'order_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
