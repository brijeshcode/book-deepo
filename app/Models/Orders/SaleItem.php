<?php

namespace App\Models\Orders;

use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['sale_id', 'bundle_id', 'book_id', 'class', 'subject' ,'quantity', 'cost', 'book_name', 'system_quantity', 'user_id','user_ip'];

    public static function booted(){
        static::created(function($saleItem){
            $saleItem->user_id = auth()->user()->id;
            $saleItem->user_ip = \Request::ip();

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
