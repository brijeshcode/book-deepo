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
    // protected $fillable = [ 'supplier_id' ,'publisher_id', 'sku_no','cost', 'warehouse_id', 'school_id' ,'subject', 'name', 'author_name', 'description', 'class', 'quantity', 'note', 'active', 'user_id', 'user_ip'];
    protected $fillable = [ 'warehouse_id', 'location_id', 'publisher_id', 'sku_no','cost', 'subject', 'name', 'author_name', 'description', 'class', 'quantity', 'note', 'active', 'user_id', 'user_ip'];

    protected $casts = [
      'active' => 'boolean'
    ];


    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withTimestamps();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class)->withTimestamps();
    }

}
