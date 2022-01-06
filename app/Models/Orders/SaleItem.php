<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['sale_id', 'bundle_id', 'book_id', 'class', 'subject' ,'quantity', 'user_id','user_ip'];

    public function order()
    {
        return $this->belongsTo(Sale::class, 'sale_id' );
    }
}
