<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Setup\Book;
use Illuminate\Http\Request;

class PublisherDeliveryController extends Controller
{
    public function store(Request $request)
    {
        // dd('publisher store');

        // Tasks
        // 1. Insert publisher delivery
        // 2. insert publisher delivery items
        // 3. update publisher order items recived quantity
        // 4. update school order items recived quantity
        // 5. update book quantity

        // $this->validateFull($request);

        \DB::transaction(function() use ($request) {
            // dd($request);
            // 1.& 2  Insert publisher delivery &&  insert publisher delivery items
            $order = PublisherOrderDelivery::create($request->only('date', 'publisher_id', 'school_id', 'publisher_order_id', 'school_order_id',  'quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'))->items()->createMany($request->items);

            /*$schoolOrder = SchoolOrder::Where( 'id', $request->school_order_id)->first();
            $schoolOrder->status = $schoolOrder->quantity ==  $order->quantity  ? 'Completed' : 'Partial';
            $schoolOrder->save();*/

            foreach ($request->items as $key => $item) {

                // 3. update publisher order items recived quantity
                $publisherItem = PublisherOrderItem::whereId($item['publisher_order_item_id'])->first();
                $publisherItem->quantity_recived += $item['quantity'];
                $publisherItem->save();

                // 4. update school order items recived quantity
                $schoolItem = SchoolOrderItem::whereId($publisherItem->school_order_item_id)->first();
                $schoolItem->recived_quantity += $item['quantity'];
                $schoolItem->save();

                // 5. update book quantity
                $book = Book::where('id', $publisherItem->book_id)->first();
                $book->quantity +=  $item['quantity'];
                $book->cost = $item['price'];
                $book->save();
            }
        });

        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');
    }
}
