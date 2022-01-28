<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\ChallanController;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Orders\SupplierOrderDeliveryItem;
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
        // check if update or store
        $delivery = SupplierOrderDelivery::where('supplier_order_id', $request->supplier_order_id)->where('supplier_id' , $request->supplier_id)->first();
        if (!is_null($delivery)) {
            $this->update($request, $delivery);
            return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');
        }

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
            $supplierDelivery = SupplierOrderDelivery::create($request->only('date', 'supplier_id', 'school_id', 'supplier_order_id', 'school_order_id',  'quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'));

            $supplierDelivery->items()->createMany($request->items);
            $supplierDelivery->challans()->createMany($request->challans);


            $schoolOrder = SchoolOrder::whereId($request->school_order_id)->first();
            $schoolOrder->status = $schoolOrder->quantity ==  $request->quantity  ? 'Completed' : 'Partial';

            $schoolOrder->save();

            foreach ($request->items as $key => $item) {

                // 3. update supplier order items recived quantity
                // 4. update school order items recived quantity
                // 5. update book quantity
                $this->updateSupplierOrderItemQuantity($item['supplier_order_item_id'], $item['quantity']);

            }
        });
        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');

    }

    public function update(Request $request, SupplierOrderDelivery $delivery)
    {
        \DB::transaction(function() use ($request, $delivery) {
            $delivery->update($request->only('quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'));

            foreach ($request->items as $key => $item) {
                $this->updateSupplierOrderItemQuantity($item['supplier_order_item_id'], $item['quantity']);

                $supplierItem = SupplierOrderDeliveryItem::where('supplier_order_item_id', $item['supplier_order_item_id'])->first();
                $supplierItem->quantity = $item['quantity'];
                $supplierItem->unit_price = $item['unit_price'];
                $supplierItem->discount_percent = $item['discount_percent'];
                $supplierItem->discount_total = $item['discount_total'];
                $supplierItem->price_total = $item['price_total'];
                $supplierItem->save();

            }

            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                if (isset($challan['id'])) {
                    $supplierChallan = SupplierChallan::where('id', $challan['id'])->first();
                    $supplierChallan->date = $challan['date'];
                    $supplierChallan->challan_no = $challan['challan_no'];
                    $supplierChallan->amount = $challan['amount'];
                    $supplierChallan->path = $challan['path'];
                    $supplierChallan->note = $challan['note'];
                    $supplierChallan->save();
                    unset($challans[$key]);
                }
            }
            if (count($challans) > 0) {
                $delivery->challans()->createMany($challans);
            }
        });
        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');
    }

    public function updateSupplierOrderItemQuantity($supplierOrderItemId, $quantity){
        $supplierItem = SupplierOrderItem::whereId($supplierOrderItemId)->first();

        $this->updateBookQuantity($supplierItem->book_id, $quantity, $supplierItem->quantity_recived);
        $this->updateSchoolOrderItemQuantity($supplierItem->school_order_item_id, $quantity);

        $supplierItem->quantity_recived = $quantity;
        $supplierItem->save();


    }

    public function updateBookQuantity($bookId,$newQty, $oldQty = 0 )
    {
        $book = Book::where('id', $bookId)->first();
        $book->quantity +=  $newQty - $oldQty;
        $book->save();
    }

    public function updateSchoolOrderItemQuantity($schoolOrderItemId, $recivedQuantity)
    {
        $schoolItem = SchoolOrderItem::whereId($schoolOrderItemId)->first();
        $schoolItem->recived_quantity = $recivedQuantity;
        $schoolItem->save();
    }
}
