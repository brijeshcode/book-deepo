<?php

namespace App\Models\Setup;

use App\Models\Orders\SchoolOrder;
use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'warehouse_id' , 'address', 'name', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'actor_id', 'actor_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function orders()
    {
        return $this->hasMany(SchoolOrder::class);
    }
}
