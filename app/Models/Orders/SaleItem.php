<?php

namespace App\Models\Orders;

use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use HasFactory,SoftDeletes;
    use Authorable;

    protected $fillable = ['sale_id', 'bundle_id', 'book_id', 'class', 'subject' ,'quantity', 'cost', 'book_name', 'system_quantity'];

    public static function booted(){
        static::created(function($saleItem){
            $book = Book::where('id', $saleItem->book_id)->first();
            $book->quantity -= $saleItem->quantity;
            $book->save();
        });
    }
    public function order()
    {
        return $this->belongsTo(Sale::class, 'sale_id' );
    }

    public function book()
    {
        return $this->belongsTo(Book::class );
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class );
    }
}
