<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\PublisherPayment;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublisherPaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['can:access {{ auth }}'])->except(['locations','warehouses','publishers','publishers']);
        // $this->middleware(['can:create {{ auth }}'])->only(['create', 'store']);
        // $this->middleware(['can:edit {{ auth }}'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $payments = PublisherPayment::with('publisher:id,name','order:id,school_id,school_order_id', 'order.school:id,name')
                ->when($request->payment_mode, function ($query, $payment_mode){
                    $query->wherePaymentMode($payment_mode);
                })
                ->when($request->amount, function ($query, $amount){
                    $query->whereAmount($amount);
                })
                ->when($request->payment_mode, function ($query, $payment_mode){
                    $query->where('payment_mode',  '='  , $payment_mode);
                })
                ->when($request->publisher_id, function ($query, $publisher_id){
                    $query->where('publisher_id',  '='  , $publisher_id);
                })
                ->when($request->publisher_order_id, function ($query, $publisher_order_id){
                    $query->where('publisher_order_id', $publisher_order_id);
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
        $publishers = Publisher::select('id', 'name')->whereActive(1)->has('payments')->get();
        return Inertia::render('Order/Publishers/Payments/Index', compact('payments', 'publishers'));
    }

    public function create(PublisherOrder $publisherOrder)
    {
        $publisherOrder->load('deliveries', 'returns', 'challans', 'payments');
        return Inertia::render('Order/Publishers/Payments/Create', compact('publisherOrder'));
    }

    public function store(Request $request)
    {
        \DB::transaction(function() use ($request) {
            PublisherPayment::create($request->only('publisher_id', 'publisher_order_id', 'date', 'payment_mode', 'amount', 'note'));
        });
        return redirect(route('publisher.payments.index'))->with('type', 'success')->with('message', 'Publisher Order Payment store successfully !!');
    }

    /*public function challanPayment(PublisherChallan $challan)
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

    }*/
}
