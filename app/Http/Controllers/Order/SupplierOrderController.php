<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierOrderItem;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders = SupplierOrder::with('supplier:id,name')->select('id', 'supplier_id','email' , 'date', 'mobile', 'fax', 'contact_person',  'note', 'total_quantity', 'total_amount' )->orderBy('id', 'desc')->paginate(5);
        return Inertia::render('Order/Suppliers/Index', compact('orders'));
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Suppliers/Create', compact('suppliers'));
    }

    public function edit(Request $request, $order_id)
    {
        $order = SupplierOrder::select('id', 'date', 'supplier_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,supplier_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $suppliers = Supplier::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Suppliers/Create', compact('suppliers', 'order'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        $order= [
            'supplier_id' => $request->supplier_id,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'date' => now(),
            'fax' => $request->fax,
            'contact_person' => $request->contact_person,
            'note' => $request->note,
            'total_quantity' => $request->total_quantity,
            'total_amount' => $request->total_amount
        ];
        $order = SupplierOrder::create($order)->items()->createMany($request->items);
        return redirect(route('supplierOrder'));
    }
    public function update(Request $request, SupplierOrder $order)
    {
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
        $this->validateFull($request);
        $order->update($orderData);

        foreach ($request->items as $reqKey => $item) {
            if (isset($item['id'])) {
                SupplierOrderItem::where('id', $item['id'])->update($item);
            }else{
                $order->items()->create($item);
            }
        }

        return redirect(route('supplierOrder'));
    }

    public function deleteItem(SupplierOrderItem $item)
    {
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
}
