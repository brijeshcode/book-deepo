<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrder;
use App\Models\Orders\SupplierPayment;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierPaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['can:access {{ auth }}'])->except(['locations','warehouses','suppliers','suppliers']);
        // $this->middleware(['can:create {{ auth }}'])->only(['create', 'store']);
        // $this->middleware(['can:edit {{ auth }}'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
      $payments = SupplierPayment::with('supplier:id,name', 'order:id,school_id,school_order_id', 'order.school:id,name')
                ->when($request->amount, function ($query, $amount){
                    $query->whereAmount($amount);
                })
                ->when($request->payment_mode, function ($query, $payment_mode){
                    $query->wherePaymentMode($payment_mode);
                })
                ->when($request->supplier_id, function ($query, $supplier_id){
                    $query->where('supplier_id', $supplier_id);
                })
                ->when($request->supplier_order_id, function ($query, $supplier_order_id){
                    $query->where('supplier_order_id', $supplier_order_id);
                })
                ->when($request->from_date, function ($query, $from_date){
                    $query->where('date',  '>=' , $from_date);
                })
                ->when($request->to_date, function ($query, $to_date){
                    $query->where('date',  '<='  , $to_date);
                })
                ->when($request->note, function ($query, $note){
                    $query->whereNote($note);
                })
            ->select('id','supplier_id', 'supplier_order_id', 'date', 'amount', 'payment_mode', 'note')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::select('id', 'name')->whereActive(1)->has('payments')->get();
        return Inertia::render('Order/Suppliers/Payments/Index', compact('payments', 'suppliers'));
    }

    public function create(SupplierOrder $supplierOrder)
    {
        $supplierOrder->load('deliveries', 'returns', 'challans', 'payments');
        return Inertia::render('Order/Suppliers/Payments/Create', compact('supplierOrder'));
    }

    public function store(Request $request)
    {
        \DB::transaction(function() use ($request) {
            SupplierPayment::create($request->only('supplier_id', 'supplier_order_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('supplier.payments.index'))->with('type', 'success')->with('message', 'Supplier Order Payment store successfully !!');
    }

    /*public function challanPayment(SupplierChallan $challan)
    {
        $challan->load('supplier:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Suppliers/Payments/Challan', compact('challan'));
    }*/

    public function showChallan(SupplierChallan $challan)
    {
        $challan->load('supplier:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Suppliers/Payments/ChallanShow', compact('challan'));
    }

    public function storeChallanPayment(Request $request)
    {
        dd('store paytment ');
        \DB::transaction(function() use ($request) {
            SupplierPayment::create($request->only('supplier_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('supplier.payments.index'))->with('type', 'success')->with('message', 'Challan Payment store successfully !!');

    }
}
