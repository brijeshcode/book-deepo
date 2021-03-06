<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\PublisherOrderController;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Orders\SupplierOrder;
use App\Models\Setup\Book;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class SchoolOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = SchoolOrder::with('school:id,name,email,mobile')
            ->when($request->quantity, function ($query, $quantity){
                $query->where('quantity',  '='  , $quantity);
            })
            ->when($request->school_id, function ($query, $school_id){
                $query->where('school_id',  '='  , $school_id);
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
            ->orderBy('id', 'desc')->paginate(5)
            ->withQueryString()
            ;

        $schools = School::has('orders')->whereActive(1)->orderBy('name', 'asc')->get();

        return Inertia::render('Order/Schools/Index', compact('orders', 'schools'));
    }

    public function create(Request $request)
    {
        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('books')->get();

        if ($schools->isEmpty()) {
            return redirect()->back()->with('type', 'info')->with('message', 'First Add books to any school And make sure school atleast one school is active.');
        }

        return Inertia::render('Order/Schools/Create', compact('schools'));
    }

    public function edit(Request $request, $order_id)
    {
        abort('403', 'Edit school order is not allowed ');

        $order = SchoolOrder::select('id','date','school_id','total_quantity','total_amount', 'fax', 'email', 'mobile',
            'contact_person')
            ->with('items:id,school_id,order_id,order_to,supplier_id,publisher_id,book_id,class,quantity,subject', 'items.book' , 'items.book.suppliers', 'items.book.publisher')
            ->where('id',$order_id)->first();

        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->get();
        $books = Book::with('suppliers', 'publisher:id,name,mobile,email')
                ->select( 'id', 'publisher_id', 'sku_no','name', 'author_name' ,'description', 'quantity', 'cost', 'class' , 'note', 'subject')
                ->where('active' , true)
                ->orderBy('name')->get();

        return Inertia::render('Order/Schools/Create', compact('schools', 'order', 'books'))->with('type', 'success')->with('message', 'Order generated successfully !!');
    }

    public function show(Request $request, $order_id)
    {
        $order = SchoolOrder::with('items', 'items.book', 'supplierDelivery', 'publisherDelivery', 'items.supplier', 'items.book.publisher', 'school', 'school.warehouse')
            ->where('id',$order_id)->first();
        return Inertia::render('Order/Schools/Show', compact('order'));
    }

    public function store(Request $request)
    {
        // dd($request->items);
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $order= [
                'school_id' => $request->school_id,
                'date' => now(),
                'note' => $request->note,
                'quantity' => $request->total_quantity,
                'amount' => $request->total_amount,
                'expected_delivery_date' => $request->expected_delivery_date
            ];
            $publisherOrders = $suppleirOrders = array();

            $order = SchoolOrder::create($order);
            $schoolOrderId = $order->id;
            $order->items()->createMany($request->items);
            // dd($order->items);
            (new SupplierOrderController())->generateOrder($order);
            (new PublisherOrderController())->generateOrder($order);
        });

        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Order generated successfully !!');
    }


    public function update(Request $request, SchoolOrder $order)
    {
        abort(403);
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $order) {
            $orderData= [
                'school_id' => $request->school_id,
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
                    SchoolOrderItem::where('id', $item['id'])->update($item);
                }else{
                    $order->items()->create($item);
                }
            }
        });
        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Order updated successfully !!');
    }

    public function deleteItem(SchoolOrderItem $item)
    {
        $item->delete();
    }

    private function validateFull($request)
    {
        $tempName = 'School';
        $request->validate(
            [
                'school_id' => 'required',
                'items' => 'required'
            ],
            [
                'school_id.required' => 'School is not selected.',
                'items.required' => "No item added in the order"
            ]
        );
    }


    public function createSchoolDelivery(Request $request, $order_id)
    {
        // return $order = SchoolOrder::with('items', 'items.book' , 'items.supplier','items.publisher' , 'school')
        $order = SchoolOrder::with('items:id,school_order_id,book_id,order_to,publisher_id,supplier_id,quantity,recived_quantity', 'items.book:id,name' , 'items.supplier:id,name,email','items.publisher:id,name,email' , 'school:id,name,email,contact_person,mobile')
            ->whereId($order_id)->first();

        $publisherOrders= PublisherOrder::with('publisher:id,name', 'items', 'items.book:id,name', 'items.delivery', 'challans')->where('school_order_id', $order_id)->get();
        $supplierOrders= SupplierOrder::with('supplier:id,name', 'items', 'items.book:id,name', 'items.delivery','challans')->where('school_order_id', $order_id)->get();

        return Inertia::render('Order/Schools/Delivery', compact('order', 'publisherOrders', 'supplierOrders'));
    }


    public function createReturn (Request $request, $order_id)
    {

       $order = SchoolOrder::with(
                'items',
                // 'items.supplierDelivery',
                // 'items.publisherDelivery',
                'items.book' ,
                'items.supplier:id,name',
                'items.publisher:id,name',
                'school'
            )
            ->where('id',$order_id)->first();

        $publisherOrders = PublisherOrder::with('deliveries.items', 'deliveries.items.book:id,name,class', 'deliveries.publisher:id,name', 'returns.items', 'challans')->where('school_order_id', $order_id)->first();
        $supplierOrders = SupplierOrder::with('deliveries.items', 'deliveries.items.book:id,name,class', 'deliveries.supplier:id,name', 'returns.items', 'challans')->where('school_order_id', $order_id)->first();

        return Inertia::render('Order/Schools/Return', compact('supplierOrders', 'order', 'publisherOrders'))->with('type', 'success')->with('message', 'Order generated successfully !!');
    }
}
