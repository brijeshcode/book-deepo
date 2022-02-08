<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SupplierChallan;
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
       $challans = SupplierChallan::with('supplier:id,name')
                ->when($request->challan_no, function ($query, $challan_no){
                    $query->where('challan_no',  '='  , $challan_no);
                })
                ->when($request->amount, function ($query, $amount){
                    $query->where('amount',  '='  , $amount);
                })
                ->when($request->payment_status, function ($query, $payment_status){
                    $query->where('payment_status',  '='  , $payment_status);
                })
                ->when($request->supplier_id, function ($query, $supplier_id){
                    $query->where('supplier_id',  '='  , $supplier_id);
                })
                ->when($request->from_date, function ($query, $from_date){
                    $query->where('date',  '>=' , $from_date);
                })
                ->when($request->to_date, function ($query, $to_date){
                    $query->where('date',  '<='  , $to_date);
                })
                ->when($request->note, function ($query, $note){
                    $query->where('note',  '='  , $note);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::select('id', 'name')->whereActive(1)->has('challans')->get();
        return Inertia::render('Order/Suppliers/Payments/Index', compact('challans', 'suppliers'));
    }

    public function create($supplierId)
    {
        $challans = SupplierChallan::whereSuppplierId($supplierId)->where("payment_status", 'due')->get();
        return Inertia::render('Order/Suppliers/Payments/Create', compact('challans'));
    }

    public function challanPayment(SupplierChallan $challan)
    {
        $challan->load('supplier:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Suppliers/Payments/Challan', compact('challan'));
    }

    public function showChallan(SupplierChallan $challan)
    {
        $challan->load('supplier:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Suppliers/Payments/ChallanShow', compact('challan'));
    }

    public function storeChallanPayment(Request $request)
    {
        \DB::transaction(function() use ($request) {
            SupplierPayment::create($request->only('supplier_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('supplier.payments.index'))->with('type', 'success')->with('message', 'Challan Payment store successfully !!');

    }
}
