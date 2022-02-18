<?php

namespace App\Models\Setup;

use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'name', 'city', 'state', 'pincode', 'note', 'active'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function publishers()
    {
        return $this->hasMany(Publisher::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
