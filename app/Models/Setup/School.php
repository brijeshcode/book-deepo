<?php
namespace App\Models\Setup;

use App\Models\Orders\SchoolOrder;
use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Models\Setup\Location;
use App\Models\Setup\SchoolDocument;
use App\Models\Setup\Warehouse;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'warehouse_id' , 'address', 'name', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person', 'note', 'active'];

    protected $casts = [ 'active' => 'boolean' ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
        // return $this->hasMany(Book::class);
    }

    public function bundles()
    {
        return $this->hasMany(Bundle::class);
    }
    public function orders()
    {
        return $this->hasMany(SchoolOrder::class);
    }

    public function documents()
    {
        return $this->hasMany(SchoolDocument::class);
    }
}
