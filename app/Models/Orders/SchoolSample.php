<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolSampleItem;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolSample extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'school_id', 'date','quantity', 'note', 'user_id', 'user_ip'];

   /* public function getDateAttribute()
    {
        return date('d-m-Y @ H:i A', strtotime($this->created_at));
    }*/

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
    public function items()
    {
        return $this->hasMany(SchoolSampleItem::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
