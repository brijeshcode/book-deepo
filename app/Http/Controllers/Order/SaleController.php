<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\Sale;
use App\Models\Orders\SaleItem;
use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Models\Setup\School;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:access sales']);
        $this->middleware(['can:create sales'])->only(['create', 'store']);
        $this->middleware(['can:edit sales'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {

        $sales = Sale::with('school:id,name')->select('id', 'date' , 'school_id', 'bundle_id', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'status' ,'total_quantity', 'note' )
                ->when($request->student_name, function ($query, $student_name){
                    $query->where('student_name',  'like', '%'. $student_name . '%');
                })
                ->when($request->student_email, function ($query, $student_email){
                    $query->where('student_email',  'like', '%'. $student_email . '%');
                })
                ->when($request->student_mobile, function ($query, $student_mobile){
                    $query->where('student_mobile',  'like', '%'. $student_mobile . '%');
                })
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('total_quantity' , $quantity);
                })
                ->when($request->amount, function ($query, $amount){
                    $query->where('total_amount' , $amount);
                })
                ->when($request->school_id, function ($query, $school_id){
                    $query->where('school_id'  , $school_id);
                })
                ->when($request->bundle_id, function ($query, $bundle_id){
                    $query->where('bundle_id', $bundle_id);
                })
                ->when($request->from_date, function ($query, $from_date){
                    $query->where('date',  '>=' , $from_date);
                })
                ->when($request->to_date, function ($query, $to_date){
                    $query->where('date',  '<='  , $to_date);
                })
                ->where(function($query) {
                    $user = auth()->user();
                    if ($user->hasRole('Operator')) $query->where('user_id', $user->id);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $schools = $this->getSchoolWithOperatorCheck();
        $bundles = $this->getSalesWtihOperatorCheck();

        return Inertia::render('Order/Sales/Index', compact('sales', 'schools', 'bundles'));
    }

    public function create(Request $request)
    {
        $schools = $this->getSchoolWithOperatorCheck();

        if ($schools->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'No active bundle in any school found, check school have alteast one active bundle and continue.');
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
        ->only('id', 'date', 'formated_date', 'bundle_id', 'discount_percent', 'discount_amount', 'school_id', 'student_name', 'status', 'student_mobile', 'student_email', 'total_amount', 'total_quantity', 'bundle', 'note', 'school', 'items');

        return Inertia::render('Order/Sales/Show', compact('sale'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {

            $order = Sale::create($request->only('name', 'discount_percent', 'discount_amount', 'school_id', 'bundle_id', 'date', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'total_quantity','note'))->items()->createMany($request->items);
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
            $sale->update($request->only('name', 'school_id', 'bundle_id', 'date', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'discount_percent', 'discount_amount', 'total_quantity','note'));

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

    public function cancel(Request $request, Sale $sale)
    {
        \DB::transaction(function() use ($request, $sale) {
            $sale->update(['status' => 'cancel']);
            if ($sale->status == 'cancel') {
                foreach ($sale->items as $key => $item) {
                    $book = Book::whereId($item->book_id)->first();
                    $book->quantity += $item->quantity ;
                    $book->save();
                }
            }

        });
        return redirect()->back()->with('type', 'success')->with('message', 'Sale Cancelled !!');
    }
    /*public function deleteItem(PublisherOrderItem $item)
    {
        $item->delete();
    }*/

    public function saveInvoice(Sale $sale)
    {
        $html = view('sales/invoice', compact('sale'))->render();

        // $now = now();
        // $location = 'SaleInvoice/'. $now->year. '/'. $now->format('m');
        $location = 'SaleInvoice';
        $pathToImage = $location .  '/INVOICE_'.$sale->id.'.pdf';
        Browsershot::html($html)
        ->showBrowserHeaderAndFooter()
        ->showBackground()
        ->margins(10,10,10,10)
        ->paperSize('89','8', 'mm')
        ->savePdf($pathToImage);
        // unlink($pathToImage);
        echo '<a href="'.asset($pathToImage).'" downlaod > Downlaod </a>';
        die;
        // return ' saved';
    }

    public function printInvoice(Sale $sale)
    {
        $sale = $sale->load( 'school:id,name,address,city,state,pincode,warehouse_id' , 'school.warehouse' , 'bundle:id,name', 'items:id,sale_id,book_id,quantity,cost,class,subject,book_name,system_quantity', 'items.book:id,sku_no,name,author_name,class,subject,publisher_id', 'items.book.publisher:id,name')
        ->only('id', 'date', 'bundle_id', 'school_id', 'student_name', 'student_mobile', 'student_email', 'total_amount', 'total_quantity', 'bundle', 'school', 'items');

        return Inertia::render('Order/Sales/invoice', compact('sale'));
    }

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

    private function getSchoolWithOperatorCheck()
    {
        $checkSchools = $this->checkOperator();
        if (empty($checkSchools)) {
            $schools = School::select('id', 'name')->where('active', 1)->orderBy('name')->has('bundles')->get();
            $bundles = Bundle::select('id', 'name')->where('active', 1)->orderBy('name')->has('sales')->get();
        }else{
            $schools = School::select('id', 'name')->whereIn('id' , $checkSchools)->where('active', 1)->orderBy('name')->has('bundles')->get();
            $bundles = Bundle::select('id', 'name')->whereIn('school_id' , $checkSchools)->where('active', 1)->orderBy('name')->has('sales')->get();
        }
        return $schools;
    }

    private function getSalesWtihOperatorCheck()
    {
        $checkSchools = $this->checkOperator();
        if (empty($checkSchools)) {
            $bundles = Bundle::select('id', 'name')->where('active', 1)->orderBy('name')->has('sales')->get();
        }else{
            $bundles = Bundle::select('id', 'name')->whereIn('school_id' , $checkSchools)->where('active', 1)->orderBy('name')->has('sales')->get();
        }
        return $bundles;
    }

    private function checkOperator()
    {
        $user = User::with('schools:id,name,active')->has('schools')->find(\Auth::id());
        $checkSchools = [];
        if ($user) {
            foreach ($user->schools as $key => $school) {
                $checkSchools[] = $school->id;
            }
        }
        return $checkSchools;
    }
}
