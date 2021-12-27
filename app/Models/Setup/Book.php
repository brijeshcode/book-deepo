<?php

namespace App\Models\Setup;

use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'supplier_id' ,'publisher_id' ,'subject', 'name', 'author_name', 'description', 'class', 'note', 'active', 'actor_id', 'actor_ip'];

    protected $casts = [
      'active' => 'boolean'
    ];

    public function suppler()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

}
