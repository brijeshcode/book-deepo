<?php

namespace App\Models\Orders;

use App\Models\Orders\SaleItem;
use App\Models\Setup\Bundle;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'date' , 'school_id', 'bundle_id', 'student_name','student_email', 'student_mobile', 'total_amount' ,'total_quantity', 'note', 'status', 'user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }

    public function getFormatedDateAttribute()
    {
        return date('d-m-Y @ H:i A', strtotime($this->created_at));
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }


    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
