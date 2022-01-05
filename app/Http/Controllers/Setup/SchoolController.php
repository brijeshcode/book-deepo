<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\School;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schools = School::with('warehouse')->orderBy('id', 'desc')->when($request->search, function ($query, $search){
            $query->where('name', 'like', '%'. $search . '%');
            $query->orWhere('contact_person', 'like', '%'. $search . '%');
            $query->orWhere('email', 'like', '%'. $search . '%');
            $query->orWhere('city', 'like', '%'. $search . '%');
            $query->orWhere('state', 'like', '%'. $search . '%');
            $query->orWhere('pincode', 'like', '%'. $search . '%');
            $query->orWhere('mobile', 'like', '%'. $search . '%');
            $query->orWhere('address', 'like', '%'. $search . '%');
            $query->orWhere('note', 'like', '%'. $search . '%');
        })
        ->paginate(10)->withQueryString()->through(fn($school) => [
            'id' => $school->id,
            'name' => $school->name,'city' => $school->city,'state' => $school->state, 'contact_person' => $school->contact_person,
            'pincode' => $school->pincode, 'email' => $school->email, 'note' => $school->note,
            'mobile'=> $school->mobile, 'active' => $school->active,
            'warehouse' => $school->warehouse->name,
            'address' => $school->address
            // 'location' => $school->warehouse->location->name
        ]);
        return Inertia::render('Setup/Schools/Index' , compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::select('id', 'name', 'city', 'state' , 'pincode')->where('active', 1)->orderBy('name')->get();
        return Inertia::render('Setup/Schools/Create', compact('warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateFull($request);
        School::create($request->all());
        return redirect(route('schools'))->with('type', 'success')->with('message', 'School added successfully !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        $warehouses = Warehouse::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        $school = $school->only('id','name', 'email', 'address', 'city', 'state', 'mobile', 'warehouse_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Schools/Create', compact('school', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        $this->validateFull($request);
        $school->update($request->all());
        return redirect(route('schools'))->with('type', 'success')->with('message', 'School updated successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkStock(Request $request, $school)
    {/*
        $schoolBooks = Book::where('school_id',$school)->where('quantity', '>', 0 )->where('active' , true)->limit(3)->get();
        $report = [];
        foreach ($request->items as $key => $item) {
            foreach ($schoolBooks as $skey => $sbook) {
                if ($item->book_id == $sbook->id  ) {
                    $report[$item->book_id] = [
                        'id' => $sbook->id,
                        'name' => $sbook->name,
                        'quantity' => $sbook->quantity
                    ];
                }
            }
        }*/
    }

    public function books($school)
    {
        $books = Book::select('id', 'sku_no', 'name', 'author_name', 'class', 'subject', 'school_id', 'warehouse_id', 'supplier_id', 'publisher_id', 'note', 'description', 'active')
            ->with('school:id,name,city,state,email,pincode,mobile,contact_person', 'supplier:id,name', 'warehouse:id,name,city,state,email,pincode,mobile,contact_person', 'publisher:id,name')
            ->where('school_id', $school)
            ->paginate(15);

        $school = School::findorFail($school);

        return Inertia::render('Setup/Schools/Books' , compact('books', 'school'));

        // return response()->json($books);
    }
    private function validateFull($request)
    {
        $tempName = 'School';
        $request->validate(
            [
                'name' => 'required|max:50',
                'city' => 'required|max:50',
                'state' => 'required|max:50',
                'pincode' => 'required|digits:6',
                'mobile' => 'required|digits:10',
                'warehouse_id' => 'required',
                'email' => 'email',
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'city.required' => $tempName .' City is empty.' ,
                'state.required' => $tempName .' State is empty.' ,
                'pincode.required' => $tempName .' Pincode is empty.' ,
                'mobile.required' => $tempName .' Moible is empty.',
                'mobile.digits' => $tempName .' Moible number must be 10 digits.',
                'email.required' => 'Enter valid Email.'
            ]
        );
    }
}
