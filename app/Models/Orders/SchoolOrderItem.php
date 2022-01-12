<?php

namespace App\Models\Orders;

use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['school_order_id', 'book_id', 'supplier_id', 'publisher_id', 'quantity' , 'order_to', 'status', 'recived_quantity','user_id','user_ip' ];

    public function order()
    {
        return $this->belongsTo(SchoolOrder::class, 'school_order_id' );
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
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
