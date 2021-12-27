<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Setup\Book;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders = SchoolOrder::with('school:id,name')->select('id', 'school_id','email' , 'date', 'mobile', 'fax', 'contact_person',  'note', 'total_quantity', 'total_amount' )->orderBy('id', 'desc')->paginate(5);
        return Inertia::render('Order/Schools/Index', compact('orders'));
    }

    public function create(Request $request)
    {
        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->get();
        $books = Book::select( 'id', 'name', 'author_name' ,'description', 'class' , 'note', 'subject'
        )->where('active' , true)->orderBy('name')->get();
        return Inertia::render('Order/Schools/Create', compact('schools', 'books'));
    }

    public function edit(Request $request, $order_id)
    {
        $order = SchoolOrder::select('id', 'date', 'school_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,school_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->get();
        $books = Book::select( 'id', 'name', 'author_name' ,'description', 'class' , 'note', 'subject'
        )->where('active' , true)->orderBy('name')->get();
        return Inertia::render('Order/Schools/Create', compact('schools', 'order', 'books'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        $order= [
            'school_id' => $request->school_id,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'date' => now(),
            'fax' => $request->fax,
            'contact_person' => $request->contact_person,
            'note' => $request->note,
            'total_quantity' => $request->total_quantity,
            'total_amount' => $request->total_amount
        ];
        $order = SchoolOrder::create($order)->items()->createMany($request->items);
        return redirect(route('schoolOrder'));
    }

    public function update(Request $request, SchoolOrder $order)
    {
        $this->validateFull($request);
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

        return redirect(route('schoolOrder'));
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
}
