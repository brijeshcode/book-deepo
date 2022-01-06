<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolOrderItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =['school_id','order_id','book_id','class','subject','quantity','order_to','publisher_id','supplier_id','user_id','user_ip'];

    public function order()
    {
        return $this->belongsTo(SchoolOrder::class, 'order_id' );
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
