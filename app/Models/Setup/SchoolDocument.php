<?php

namespace App\Models\Setup;

use App\Models\Setup\School;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDocument extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'title', 'school_id', 'link', 'note'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
