<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderDelivery;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

// edit, store , update has been blocked for time been, due to logic confliction .
class SupplierOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        /*return $orders = SchoolOrder::has('items.supplier')->with('items:id,order_id,supplier_id', 'items.supplier:id,name')->paginate(10);
        return $orders = SchoolOrderItem::where('order_to', 'Supplier')->get();*/
        // $orders = SupplierOrder::with('supplier:id,name')->select('id', 'school_id', 'supplier_id','email' , 'date', 'mobile', 'fax', 'contact_person',  'note', 'total_quantity', 'total_amount' )->orderBy('id', 'desc')
        $orders = SupplierOrder::with('supplier:id,name')->orderBy('id', 'desc')
        ->paginate(10)->withQueryString();
        return Inertia::render('Order/Suppliers/Index', compact('orders'));
    }

    public function create(Request $request)
    {
        return abort(404);
        return $suppliers = Supplier::select('id','location_id', 'name','email','mobile','contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Suppliers/Create', compact('suppliers'));
    }

    public function edit(Request $request, $order_id)
    {
        return abort(404);
        $order = SupplierOrder::select('id', 'date', 'supplier_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,supplier_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $suppliers = Supplier::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Suppliers/Create', compact('suppliers', 'order'));
    }

    public function delivery(Request $request, $order_id)
    {
        $order = SupplierOrder::select('id', 'date', 'supplier_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,supplier_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $suppliers = Supplier::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Suppliers/Delivery', compact('suppliers', 'order'));
    }

    public function store(Request $request)
    {
        return abort(404);
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $order = SupplierOrder::create($request->only('supplier_id',  'email', 'date', 'mobile', 'fax', 'contact_person', 'note', 'total_quantity', 'total_amount'))->items()->createMany($request->items);
        });
        return redirect(route('supplierOrder'))->with('type', 'success')->with('message', 'Order generated successfully !!');
    }
    public function update(Request $request, SupplierOrder $order)
    {
        return abort(404);
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $order) {
            $orderData= [
                'supplier_id' => $request->supplier_id,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'date' => $request->date,
                'fax' => $request->fax,
                'contact_person' => $request->contact_person,
                'note' => $request->note,
                'total_quantity' => $request->total_quantity,
                'total_amount' => $request->total_amount
            ];

            $order->update($orderData);

            foreach ($request->items as $reqKey => $item) {
                if (isset($item['id'])) {
                    SupplierOrderItem::where('id', $item['id'])->update($item);
                }else{
                    $order->items()->create($item);
                }
            }
        });

        return redirect(route('supplierOrder'))->with('type', 'success')->with('message', 'Order updated successfully !!');
    }

    public function deleteItem(SupplierOrderItem $item)
    {
        return abort(404);
        $item->delete();
    }

    private function validateFull($request)
    {
        $tempName = 'Supplier';
        $request->validate(
            [
                'supplier_id' => 'required',
                'items' => 'required'
            ],
            [
                'supplier_id.required' => 'Supplier is not selected.',
                'items.required' => "No item added in the order"
            ]
        );
    }

    public function deliveryIndex(Request $request)
    {
        $deliveries = SupplierOrderDelivery::with('book', 'supplier')->paginate(10);
        return Inertia::render('Order/Suppliers/DeliveryIndex', compact('deliveries'));

    }
}
