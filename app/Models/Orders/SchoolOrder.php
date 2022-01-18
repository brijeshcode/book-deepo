<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'school_id', 'status', 'date','quantity', 'amount', 'note', 'user_id', 'user_ip'];

    public function getDateAttribute()
    {
        return date('d-m-Y @ H:i A', strtotime($this->created_at));
    }

    public function items()
    {
        return $this->hasMany(SchoolOrderItem::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function supplierDelivery()
    {
        return $this->hasMany(SupplierOrderDelivery::class);
    }

    public function publisherDelivery()
    {
        return $this->hasMany(PublisherOrderDelivery::class);
    }
}
