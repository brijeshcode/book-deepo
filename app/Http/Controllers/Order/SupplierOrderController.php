<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Mail\SupplierOrderMail;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Orders\SupplierOrderReturn;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

// edit, store , update has been blocked for time been, due to logic confliction .
class SupplierOrderController extends Controller
{
    //
    public function index(Request $request)
    {

        $orders = SupplierOrder::with('supplier:id,name')
        ->when($request->quantity, function ($query, $quantity){
                $query->where('quantity',  '='  , $quantity);
            })
            ->when($request->supplier_id, function ($query, $supplier_id){
                $query->where('supplier_id',  '='  , $supplier_id);
            })
            ->when($request->status, function ($query, $status){
                $query->where('status',  '='  , $status);
            })
            ->when($request->from_date, function ($query, $from_date){
                $query->where('date',  '>=' , $from_date);
            })
            ->when($request->to_date, function ($query, $to_date){
                $query->where('date',  '<='  , $to_date);
            })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

        $suppliers = Supplier::has('orders')->whereActive(1)->orderBy('name', 'asc')->get();
        return Inertia::render('Order/Suppliers/Index', compact('orders','suppliers'));
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

    public function show(SupplierOrder $order)
    {

        $order = $order->load(
                'schoolOrder:id,school_id,date,status',
                'schoolOrder.school:id,warehouse_id,name,city,address,pincode,state',
                'schoolOrder.school.warehouse:id,name,city,address,pincode,state,email,mobile',
                'supplier:id,name,mobile,email,contact_person',
                'items:id,supplier_order_id,book_id,quantity',
                'items.book:id,name,class,sku_no,subject,publisher_id',
                'items.book.publisher:id,name'
            )
        ->only('id','date' ,'amount', 'quantity', 'supplier_id', 'school_order_id', 'status', 'supplier','schoolOrder', 'items');

        return Inertia::render('Order/Suppliers/Show', compact( 'order'));
    }

    public function store(Request $request)
    {
        return abort(404);
       /* $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $order = SupplierOrder::create($request->only('supplier_id',  'email', 'date', 'mobile', 'fax', 'contact_person', 'note', 'total_quantity', 'total_amount'))->items()->createMany($request->items);
        });
        return redirect(route('supplierOrder'))->with('type', 'success')->with('message', 'Order generated successfully !!');*/
    }

    public function generateOrder($schoolOrder)
    {
        $orders = array();
        foreach ($schoolOrder->items as $key => $item) {
            if ($item['order_to'] != 'Supplier') continue;

            if (!isset($orders[$item['supplier_id']])) {
                $orders[$item['supplier_id']] = [
                    'school_order_id' => $item['school_order_id'],
                    'date' => now(),
                    'supplier_id' => $item['supplier_id'],
                    'school_id'  => $schoolOrder->school_id ,
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }

            $orders[$item['supplier_id']]['items'][] = [
                'school_order_item_id' => $item['id'],
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
            ];

            $orders[$item['supplier_id']]['quantity'] += $item['quantity'];
        }

        if (count($orders) > 0) {
            foreach ($orders as $key => $order) {
                $this->createOrder($order);
            }
        }
    }

    public function createOrder($order)
    {
        $suppOrder = SupplierOrder::create($order);
        $orderId = $suppOrder->id;
        $suppOrder->items()->createMany($order['items']);
        $this->sendMail($orderId);
    }

    public function sendMail($supplierOrderId)
    {
        $supplierOrder = SupplierOrder::with('items', 'items.book', 'items.book.publisher', 'supplier')->where('id', $supplierOrderId)->first();
        Mail::to($supplierOrder->supplier->email)->send(new SupplierOrderMail($supplierOrder));
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



    public function returnIndex(Request $request)
    {
        $returns = SupplierOrderReturn::with('supplier', 'order', 'order.school')
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('quantity',  '='  , $quantity);
                })
                ->when($request->supplier_order_id, function ($query, $supplier_order_id){
                    $query->where('supplier_order_id',  '='  , $supplier_order_id);
                })
                ->when($request->supplier_id, function ($query, $supplier_id){
                    $query->where('supplier_id',  '='  , $supplier_id);
                })
                ->when($request->date, function ($query, $date){
                    $query->where('date',  '='  , $date);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $suppliers = Supplier::select('id', 'name')->whereActive(1)->has('returns')->get();
        return Inertia::render('Order/Suppliers/ReturnIndex', compact('returns','suppliers'));
    }

    public function returnShow(Request $request, $return_id)
    {
        dd($return_id);
        $returns = SupplierOrderReturn::with('supplier')->paginate(10);
        return Inertia::render('Order/Suppliers/DeliveryIndex', compact('returns'));
    }
}
