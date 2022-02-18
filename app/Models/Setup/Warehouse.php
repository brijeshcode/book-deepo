<?php

namespace App\Models\Setup;

use App\Models\Setup\Location;
use App\Models\Setup\School;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'location_id' , 'name','address', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
