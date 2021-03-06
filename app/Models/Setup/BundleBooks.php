<?php

namespace App\Models\Setup;

use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundleBooks extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'bundle_id',  'book_id', 'class', 'subject', 'quantity'];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
