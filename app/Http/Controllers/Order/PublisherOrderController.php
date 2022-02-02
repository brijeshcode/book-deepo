<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Mail\MailPublisherOrder;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

// edit, store , update has been blocked for time been, due to logic confliction .
class PublisherOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders = PublisherOrder::with('publisher:id,name')
            ->when($request->quantity, function ($query, $quantity){
                $query->where('quantity',  '='  , $quantity);
            })
            ->when($request->publisher_id, function ($query, $publisher_id){
                $query->where('publisher_id',  '='  , $publisher_id);
            })
            ->when($request->status, function ($query, $status){
                $query->where('status',  '='  , $status);
            })
            ->when($request->date, function ($query, $date){
                $query->where('date',  '='  , $date);
            })
            ->orderBy('id', 'desc')->paginate(5)
            ->withQueryString();

        $publishers = Publisher::has('orders')->whereActive(1)->orderBy('name', 'asc')->get();
        return Inertia::render('Order/Publishers/Index', compact('orders', 'publishers'));
    }


    public function create(Request $request)
    {
        return abort(404);
        $publishers = Publisher::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Publishers/Create', compact('publishers'));
    }


    public function edit(Request $request, $order_id)
    {
        return abort(404);
        $order = PublisherOrder::select('id', 'date', 'publisher_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,publisher_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $publishers = Publisher::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Publishers/Create', compact('publishers', 'order'));
    }

    public function show(PublisherOrder $order)
    {
        // return abort(404);
        $order = $order->load(
                'schoolOrder:id,school_id,date,status',
                'schoolOrder.school:id,warehouse_id,name,city,address,pincode,state',
                'schoolOrder.school.warehouse:id,name,city,address,pincode,state,email,mobile',
                'publisher:id,name,mobile,email,contact_person',
                'items:id,publisher_order_id,book_id,quantity',
                'items.book:id,name,class,sku_no,subject,publisher_id',
                'items.book.publisher:id,name'
            )
        ->only('id','date' ,'amount', 'quantity', 'publisher_id', 'school_order_id', 'status', 'publisher','schoolOrder', 'items');

        return Inertia::render('Order/Publishers/Show', compact( 'order'));
    }


    public function store(Request $request)
    {
        return abort(404);
        /*$this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $order= [
                'publisher_id' => $request->publisher_id,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'date' => now(),
                'fax' => $request->fax,
                'contact_person' => $request->contact_person,
                'note' => $request->note,
                'total_quantity' => $request->total_quantity,
                'total_amount' => $request->total_amount
            ];
            $order = PublisherOrder::create($order)->items()->createMany($request->items);
        });
        return redirect(route('publisher.order.index'))->with('type', 'success')->with('message', 'Order generated successfully !!');*/
    }

    public function update(Request $request, PublisherOrder $order)
    {
        return abort(404);
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $order) {
            $orderData= [
                'publisher_id' => $request->publisher_id,
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
                    PublisherOrderItem::where('id', $item['id'])->update($item);
                }else{
                    $order->items()->create($item);
                }
            }
        });
        return redirect(route('publisher.order.index'))->with('type', 'success')->with('message', 'Order updated successfully !!');
    }


    public function delivery(Request $request, $order_id)
    {
        // return abort(404);
        $order = PublisherOrder::select('id', 'date', 'publisher_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,publisher_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $publishers = Publisher::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Publishers/Delivery', compact('publishers', 'order'));
    }

    public function generateOrder($schoolOrder)
    {
        $orders = array();
        foreach ($schoolOrder->items as $key => $item) {
            if ($item['order_to'] == 'Supplier') continue;

            if (!isset($orders[$item['publisher_id']])) {
                $orders[$item['publisher_id']] = [
                    'school_order_id' => $item['school_order_id'],
                    'date' => now(),
                    'publisher_id' => $item['publisher_id'],
                    'school_id'  => $schoolOrder->school_id ,
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }

            $orders[$item['publisher_id']]['items'][] = [
                'school_order_item_id' => $item['id'],
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
            ];

            $orders[$item['publisher_id']]['quantity'] += $item['quantity'];
        }

        if (count($orders) > 0) {
            foreach ($orders as $key => $order) {
                $this->createOrder($order);
            }
        }
    }

    public function createOrder($order)
    {
        $suppOrder = PublisherOrder::create($order);
        $orderId = $suppOrder->id;
        $suppOrder->items()->createMany($order['items']);
        $this->sendMail($orderId);
    }

    public function sendMail($publisherOrderId)
    {
        $publisherOrder = PublisherOrder::with('items', 'items.book', 'items.book.publisher', 'publisher')->where('id', $publisherOrderId)->first();
        Mail::to($publisherOrder->publisher->email)->send(new MailPublisherOrder($publisherOrder));
    }


    public function deleteItem(PublisherOrderItem $item)
    {
        return abort(404);
        $item->delete();
    }

    private function validateFull($request)
    {
        $tempName = 'Publisher';
        $request->validate(
            [
                'publisher_id' => 'required',
                'items' => 'required'
            ],
            [
                'publisher_id.required' => 'Publisher is not selected.',
                'items.required' => "No item added in the order"
            ]
        );
    }

    public function deliveryIndex(Request $request)
    {
        $deliveries = PublisherOrderDelivery::with('book', 'publisher')->paginate(10);
        return Inertia::render('Order/Publishers/DeliveryIndex', compact('deliveries'));
    }

    public function returnIndex(Request $request)
    {
        $returns = PublisherOrderReturn::with('publisher:id,name')
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('quantity',  '='  , $quantity);
                })
                ->when($request->publisher_order_id, function ($query, $publisher_order_id){
                    $query->where('publisher_order_id',  '='  , $publisher_order_id);
                })
                ->when($request->publisher_id, function ($query, $publisher_id){
                    $query->where('publisher_id',  '='  , $publisher_id);
                })
                ->when($request->date, function ($query, $date){
                    $query->where('date',  '='  , $date);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $publishers = Publisher::select('id', 'name')->whereActive(1)->has('returns')->get();
        return Inertia::render('Order/Publishers/ReturnIndex', compact('returns', 'publishers'));
    }
}
