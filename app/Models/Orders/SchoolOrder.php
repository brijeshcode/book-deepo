<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolOrderItem;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'school_id', 'email', 'date', 'mobile', 'fax' ,'contact_person',  'note', 'total_quantity','total_amount','user_id', 'user_ip'];

    public function items()
    {
        return $this->hasMany(SchoolOrderItem::class, 'order_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
