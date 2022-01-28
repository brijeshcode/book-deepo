<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublisherPaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['can:access {{ auth }}'])->except(['locations','warehouses','suppliers','publishers']);
        // $this->middleware(['can:create {{ auth }}'])->only(['create', 'store']);
        // $this->middleware(['can:edit {{ auth }}'])->only(['edit', 'update']);
    }

    public function index()
    {
       $challans = PublisherChallan::with('publisher')->orderBy('school_order_id', 'desc')->paginate(10);
        return Inertia::render('Order/Publishers/Payments/Index', compact('challans'));
    }

    public function create($publisherId)
    {
        $challans = PublisherChallan::wherePublisherId($publisherId)->where("payment_status", 'due')->get();
        return Inertia::render('Order/Publishers/Payments/Create', compact('challans'));
    }

    public function challanPayment(PublisherChallan $challan)
    {
        $challan->load('publisher:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Publishers/Payments/Challan', compact('challan'));
    }

    public function showChallan(PublisherChallan $challan)
    {
        $challan->load('publisher:id,name', 'delivery:id,date,quantity,discount_percent,discount,total_amount', 'schoolOrder:id,date,status,note,quantity,amount');
        return Inertia::render('Order/Publishers/Payments/ChallanShow', compact('challan'));
    }

    public function storeChallanPayment(Request $request)
    {
        \DB::transaction(function() use ($request) {
            PublisherPayment::create($request->only('publisher_id', 'challan_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('publisher.payments.index'))->with('type', 'success')->with('message', 'Challan Payment store successfully !!');

    }
}
