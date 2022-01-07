<?php

namespace App\Models\Orders;

use App\Models\Orders\SaleItem;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'date' , 'school_id', 'bundle_id', 'student_name','student_email', 'student_mobile', 'total_amount' ,'total_quantity', 'note', 'user_id', 'user_ip'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
