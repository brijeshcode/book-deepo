<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['school_id', 'order_id', 'book_id', 'class', 'subject' ,'quantity', 'actor_id','actor_ip'];

    public function order()
    {
        return $this->belongsTo(SchoolOrder::class, 'order_id' );
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
