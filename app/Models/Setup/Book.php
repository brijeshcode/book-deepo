<?php

namespace App\Models\Setup;

use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'supplier_id' ,'publisher_id', 'sku_no','cost', 'warehouse_id', 'school_id' ,'subject', 'name', 'author_name', 'description', 'class', 'quantity', 'note', 'active', 'actor_id', 'actor_ip'];

    protected $casts = [
      'active' => 'boolean'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}
