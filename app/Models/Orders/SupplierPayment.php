<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierChallan;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'supplier_id', 'challan_id', 'date', 'amount', 'payment_mode', 'note'];


    public function challan()
    {
        return $this->belongsTo(SupplierChallan::class , 'challan_id');
    }
}
