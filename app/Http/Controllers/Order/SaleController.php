<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\Sale;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    //
    public function index(Request $request)
    {
        $sales = Sale::with('school:id,name')->select('id', 'date' , 'school_id', 'bundle_id', 'student_name', 'total_amount' ,'total_quantity', 'note' )->orderBy('id', 'desc')->paginate(5);
        return Inertia::render('Order/Sales/Index', compact('sales'));
    }

    public function create(Request $request)
    {
        $schools = School::select('id', 'name')->where('active', 1)->orderBy('name')->has('bundles')->get();
        return Inertia::render('Order/Sales/Create', compact('schools'));
    }

    public function edit(Request $request, $order_id)
    {
        $order = Sale::select('id', 'date', 'publisher_id', 'total_quantity', 'total_amount', 'fax', 'email' ,'mobile', 'contact_person' )
                ->with('items:id,publisher_id,order_id,book_id,class,quantity,subject')
                ->where('id', $order_id)->first();
        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)->orderBy('name')->has('bundles')->get();
        return Inertia::render('Order/Sales/Create', compact('schools', 'order'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $order= [
                'name' => $request->name,
                'school_id' => $request->school_id,
                'bundle_id' => $request->bundle_id,
                'date' => $request->date,
                'student_name' => $request->student_name,
                'note' => $request->note,
                'total_quantity' => $request->total_quantity,
                'total_amount' => $request->total_amount
            ];
            $order = Sale::create($order)->items()->createMany($request->items);
        });
        return redirect(route('sales'))->with('type', 'success')->with('message', 'Sales generated successfully !!');
    }
    public function update(Request $request, Sale $order)
    {
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
        $this->validateFull($request);
        $order->update($orderData);

        foreach ($request->items as $reqKey => $item) {
            if (isset($item['id'])) {
                PublisherOrderItem::where('id', $item['id'])->update($item);
            }else{
                $order->items()->create($item);
            }
        }

        return redirect(route('sales'))->with('type', 'success')->with('message', 'Sales updated successfully !!');
    }

    public function deleteItem(PublisherOrderItem $item)
    {
        $item->delete();
    }

    private function validateFull($request)
    {
        $tempName = 'Sale';
        $request->validate(
            [
                'school_id' => 'required',
                'bundle_id' => 'required',
                'items' => 'required'
            ],
            [
                'school_id.required' => 'School is not selected.',
                'bundle_id.required' => 'Bundle is not selected.',
                'items.required' => "No item added in the order"
            ]
        );
    }
}
