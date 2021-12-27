<?php

namespace App\Models\Setup;

use App\Models\Setup\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'location_id' , 'name', 'city', 'state', 'pincode',  'email' ,'mobile', 'fax' ,'contact_person',  'note', 'active', 'actor_id', 'actor_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
