<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierPayment;
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

    public function index()
    {
       $challans = SupplierChallan::with('supplier')->orderBy('school_order_id', 'desc')->paginate(10);
        return Inertia::render('Order/Suppliers/Payments/Index', compact('challans'));
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

    public function storeChallanPayment(Request $request)
    {
        \DB::transaction(function() use ($request) {
            SupplierPayment::create($request->only('supplier_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('supplier.payments.index'))->with('type', 'success')->with('message', 'Challan Payment store successfully !!');

    }
}
