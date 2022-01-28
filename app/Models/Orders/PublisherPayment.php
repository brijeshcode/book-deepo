<?php

namespace App\Models\Orders;

use App\Models\Orders\PublisherChallan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherPayment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'publisher_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note', 'user_id', 'user_ip'];


    public static function boot()
    {
        parent::boot();
        static::created(function($payment)
        {
            PublisherChallan::whereId($payment->challan_id)->update(['payment_status'=> 'paid']);
            /*$model->actor_id = Auth()->user()->id;
            $model->actor_ip = \Request::ip();
            $model->active = '1';*/
        });
    }

    public function challan()
    {
        return $this->belongsTo(PublisherChallan::class , 'challan_id');
    }

}
