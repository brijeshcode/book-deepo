<?php

namespace App\Models\Orders;

use App\Models\Orders\SchoolSample;
use App\Models\Setup\Publisher;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolSampleItem extends Model
{
    use Authorable;
    use HasFactory,SoftDeletes;
    protected $fillable = ['school_sample_id', 'name', 'class', 'subject',  'publisher_id', 'quantity'];

    public function schoolSample()
    {
        return $this->belongsTo(SchoolSample::class, 'school_sample_id' );
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

}