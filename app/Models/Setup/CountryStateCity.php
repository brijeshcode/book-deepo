<?php

namespace App\Models\Setup;

use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryStateCity extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'name', 'parent_id'];
}
