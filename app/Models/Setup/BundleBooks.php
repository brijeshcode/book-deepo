<?php

namespace App\Models\Setup;

use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundleBooks extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'bundle_id',  'book_id', 'class', 'subject', 'quantity',  'user_id', 'user_ip'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->user_id = auth()->user()->id;
            $model->user_ip = \Request::ip();
        });
    }
    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
