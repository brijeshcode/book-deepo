<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;

// edit, store , update has been blocked for time been, due to logic confliction .
class PublisherOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        // $orders = PublisherOrder::with('publisher:id,name')->select('id', 'publisher_id','email' , 'date', 'mobile', 'fax', 'contact_person',  'note', 'total_quantity', 'total_amount' )->orderBy('id', 'desc')->paginate(5);
        $orders = PublisherOrder::with('publisher:id,name')->orderBy('id', 'desc')->paginate(5);
        return Inertia::render('Order/Publishers/Index', compact('orders'));
    }


    public function create(Request $request)
    {
        return abort(404);
        $publishers = Publisher::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Publishers/Create', compact('publishers'));
    }


    public function edit(Request $request, $order_id)
    {
        // return abort(404);
        $order = PublisherOrder::select('id', 'date', 'publisher_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,publisher_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $publishers = Publisher::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();
        return Inertia::render('Order/Publishers/Create', compact('publishers', 'order'));
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


    public function store(Request $request)
    {
        return abort(404);
        $this->validateFull($request);
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
        return redirect(route('publishersOrder'))->with('type', 'success')->with('message', 'Order generated successfully !!');
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
        return redirect(route('publishersOrder'))->with('type', 'success')->with('message', 'Order updated successfully !!');
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
        $returns = PublisherOrderReturn::with('publisher')->paginate(10);
        return Inertia::render('Order/Publishers/ReturnIndex', compact('returns'));
    }
}
