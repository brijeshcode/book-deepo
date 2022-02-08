<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherPayment;
use App\Models\Setup\Publisher;
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

    public function index(Request $request)
    {
        $challans = PublisherChallan::with('publisher:id,name')
                ->when($request->challan_no, function ($query, $challan_no){
                    $query->where('challan_no',  '='  , $challan_no);
                })
                ->when($request->amount, function ($query, $amount){
                    $query->where('amount',  '='  , $amount);
                })
                ->when($request->payment_status, function ($query, $payment_status){
                    $query->where('payment_status',  '='  , $payment_status);
                })
                ->when($request->publisher_id, function ($query, $publisher_id){
                    $query->where('publisher_id',  '='  , $publisher_id);
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
        $publishers = Publisher::select('id', 'name')->whereActive(1)->has('challans')->get();
        return Inertia::render('Order/Publishers/Payments/Index', compact('challans', 'publishers'));
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
