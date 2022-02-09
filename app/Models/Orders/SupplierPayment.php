<?php

namespace App\Models\Orders;

use App\Models\Orders\SupplierChallan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'supplier_id', 'challan_id', 'date', 'amount', 'payment_mode', 'note', 'user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::created(function($payment)
        {
            $payment->user_id = auth()->user()->id;
            $payment->user_ip = \Request::ip();
            SupplierChallan::whereId($payment->challan_id)->update(['payment_status'=> 'paid']);
        });
    }

    public function challan()
    {
        return $this->belongsTo(SupplierChallan::class , 'challan_id');
    }
}
