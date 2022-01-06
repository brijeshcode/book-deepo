<?php

namespace App\Models\Setup;

use App\Models\Setup\BundleBooks;
use App\Models\Setup\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'name', 'class', 'school_id', 'note', 'active', 'user_id', 'user_ip'];

    protected $casts = [
      'active' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function items()
    {
        return $this->hasMany(BundleBooks::class, 'bundle_id');
    }

}
