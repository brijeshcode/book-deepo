<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\Sale;
use App\Models\Orders\SaleItem;
use App\Models\Setup\School;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    //
    public function index(Request $request)
    {
        $sales = Sale::with('school:id,name')->select('id', 'date' , 'school_id', 'bundle_id', 'student_name', 'student_mobile', 'student_email', 'total_amount' ,'total_quantity', 'note' )->orderBy('id', 'desc')->paginate(5);
        return Inertia::render('Order/Sales/Index', compact('sales'));
    }

    public function create(Request $request)
    {
        // $user = User::with('schools:id,name,active')->has('schools')->find(8);
        $user = User::with('schools:id,name,active')->has('schools')->find(\Auth::id());
        $checkSchool = [];
        if ($user) {
            foreach ($user->schools as $key => $school) {
                $checkSchool[] = $school->id;
            }
        }
        if (empty($checkSchool)) {
            $schools = School::select('id', 'name')->where('active', 1)->orderBy('name')->has('bundles')->get();
        }else{
            $schools = School::select('id', 'name')->whereIn('id' , $checkSchool)->where('active', 1)->orderBy('name')->has('bundles')->get();
        }

        if ($schools->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'Check shcool have alteast one active bundle.');
        }
        return Inertia::render('Order/Sales/Create', compact('schools'));
    }

    public function edit(Request $request, $order_id)
    {
        $sale = Sale::select('id', 'date', 'school_id', 'total_quantity', 'total_amount', 'student_name', 'student_mobile', 'student_email', 'bundle_id' ,'note' )
                ->with('items:id,bundle_id,sale_id,book_id,class,book_name,quantity,subject,cost,system_quantity')
                ->where('id', $order_id)->first();
        $schools = School::select('id', 'name', 'email' ,'mobile', 'contact_person')->where('active', 1)
            ->orderBy('name')
            ->has('bundles')->get();


        return Inertia::render('Order/Sales/Create', compact('schools', 'sale'));
    }

    public function show(Sale $sale)
    {
        $sale = $sale->load( 'school:id,name,address,city,state,pincode,warehouse_id' , 'school.warehouse' , 'bundle:id,name', 'items:id,sale_id,book_id,quantity,cost,class,subject,book_name,system_quantity', 'items.book:id,sku_no,name,author_name,class,subject,publisher_id', 'items.book.publisher:id,name')
        ->only('id', 'date', 'bundle_id', 'school_id', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'total_quantity', 'bundle', 'school', 'items');

        return Inertia::render('Order/Sales/Show', compact('sale'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {

            $order = Sale::create($request->only('name', 'school_id', 'bundle_id', 'date', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'total_quantity','note'))->items()->createMany($request->items);
        });

        return redirect()->back()->with('type', 'success')->with('message', 'Sales generated successfully !!');
    }


    public function update(Request $request, Sale $sale)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $sale) {
            $allItems = array();
            $currentItems = array();
            foreach ($sale->items as $key => $item) {
                $allItems[] = $item->id;
            }
            $sale->update($request->only('name', 'school_id', 'bundle_id', 'date', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'total_quantity','note'));

            foreach ($request->items as $reqKey => $item) {
                if (isset($item['id'])) {
                    $currentItems[] = $item['id'];
                    SaleItem::where('id', $item['id'])->update($item);
                }else{
                    $sale->items()->create($item);
                }
            }

            $deletedItems = array_diff($allItems, $currentItems);
            if ($deletedItems ) {
                SaleItem::destroy($deletedItems);
            }
        });


        return redirect(route('sales.index'))->with('type', 'success')->with('message', 'Sales updated successfully !!');
    }

    /*public function deleteItem(PublisherOrderItem $item)
    {
        $item->delete();
    }*/

    private function validateFull($request)
    {
        $tempName = 'Sale';
        $request->validate(
            [
                'school_id' => 'required',
                'bundle_id' => 'required',
                'student_name' => 'required',
                'items' => 'required'
            ],
            [
                'school_id.required' => 'School is not selected.',
                'bundle_id.required' => 'Bundle is not selected.',
                'student_name.required' => 'Student name cannot be empty',
                'items.required' => "No item added in the order"

            ]
        );
    }
}
