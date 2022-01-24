<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierDeliveryController extends Controller
{
    public function index(Request $request)
    {

        $deliveries = SupplierOrderDelivery::with('supplier')->paginate(10);
        return Inertia::render('Order/Suppliers/Deliveries/Index', compact('deliveries'));
    }

    public function create(Request $request, $order_id)
    {

        $order = SchoolOrder::with('items', 'items.book' , 'items.supplier','items.publisher' , 'school')
            ->where('id',$order_id)->first();

        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')
                    ->where('active', 1)->orderBy('name')->get();

        $books = Book::with('suppliers', 'publisher:id,name,mobile,email')
                ->select( 'id', 'publisher_id', 'sku_no','name', 'author_name' ,'description', 'quantity', 'cost', 'class' , 'note', 'subject')
                ->where('active' , true)
                ->orderBy('name')->get();

        return Inertia::render('Order/Schools/Delivery', compact('schools', 'order', 'books'))->with('type', 'success')->with('message', 'Order generated successfully !!');
    }

    public function store(Request $request)
    {
        // dd('supplier store');

        // Tasks
        // 1. Insert supplier delivery
        // 2. insert supplier delivery items
        // 3. update supplier order items recived quantity
        // 4. update school order items recived quantity
        // 5. update book quantity

        // $this->validateFull($request);

        \DB::transaction(function() use ($request) {
            // dd($request);
            // 1.& 2  Insert supplier delivery &&  insert supplier delivery items
            SupplierOrderDelivery::create($request->only('date', 'supplier_id', 'school_id', 'supplier_order_id', 'school_order_id',  'quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'))->items()->createMany($request->items);


            $schoolOrder = SchoolOrder::whereId($request->school_order_id)->first();
            $schoolOrder->status = $schoolOrder->quantity ==  $request->quantity  ? 'Completed' : 'Partial';

            $schoolOrder->save();

            foreach ($request->items as $key => $item) {

                // 3. update supplier order items recived quantity
                $supplierItem = SupplierOrderItem::whereId($item['supplier_order_item_id'])->first();
                $supplierItem->quantity_recived += $item['quantity'];
                $supplierItem->save();

                // 4. update school order items recived quantity
                $schoolItem = SchoolOrderItem::whereId($supplierItem->school_order_item_id)->first();
                $schoolItem->recived_quantity += $item['quantity'];
                $schoolItem->save();

                // 5. update book quantity
                $book = Book::where('id', $supplierItem->book_id)->first();
                $book->quantity +=  $item['quantity'];
                $book->cost = $item['price'];
                $book->save();
            }
        });
        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');

    }
}
