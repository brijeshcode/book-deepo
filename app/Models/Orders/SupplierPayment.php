<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierChallan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'supplier_id', 'challan_id', 'date', 'amount', 'note', 'user_id', 'user_ip'];

    public function challan()
    {
        return $this->belongsTo(SupplierChallan::class , 'challan_id');
    }
}
