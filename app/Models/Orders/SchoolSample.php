<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolSampleItem;
use App\Models\Setup\School;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolSample extends Model
{
    use Authorable;
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'school_id', 'date','quantity', 'note'];

   /* public function getDateAttribute()
    {
        return date('d-m-Y @ H:i A', strtotime($this->created_at));
    }*/


    public function items()
    {
        return $this->hasMany(SchoolSampleItem::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
