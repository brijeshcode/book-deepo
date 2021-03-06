<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Location;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:access suppliers'])->except(['books']);
        $this->middleware(['can:create suppliers'])->only(['create', 'store']);
        $this->middleware(['can:edit suppliers'])->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::with('location')->orderBy('id', 'desc')
         ->when($request->search, function ($query, $search){
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
        ->paginate(10)->withQueryString()->through(fn($supplier) => [
            'id' => $supplier->id,
            'name' => $supplier->name,'city' => $supplier->city,'state' => $supplier->state, 'contact_person' => $supplier->contact_person,
            'pincode' => $supplier->pincode, 'email' => $supplier->email, 'note' => $supplier->note,
            'mobile'=> $supplier->mobile, 'active' => $supplier->active,
            'location' => $supplier->location->name,
            'address' => $supplier->address
        ]);
        return Inertia::render('Setup/Supplier/Index' , compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();

        if ($locations->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'First Add locations And make sure atleast one location is active.');
        }
        return Inertia::render('Setup/Supplier/Create', compact('locations'));
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
        Supplier::create($request->all());
        return redirect(route('suppliers'))->with('type', 'success')->with('message', 'Supplier added successfully !!');
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
    public function edit(Supplier $supplier)
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        $supplier = $supplier->only('id','name', 'address', 'email', 'city', 'state', 'mobile', 'location_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Supplier/Create', compact('supplier', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validateFull($request);
        $supplier->update($request->all());
        return redirect(route('suppliers'))->with('type', 'success')->with('message', 'Supplier added successfully !!');
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

    public function books($supplier_id)
    {
        return Supplier::select('id', 'name')->with('books:id,publisher_id,warehouse_id,name,class,subject,author_name')->where('id' , $supplier_id)->first();
    }

    private function validateFull($request)
    {
        $tempName = 'Supplier';
        $request->validate(
            [
                'name' => 'required|max:50',
                'city' => 'required|max:50',
                'state' => 'required|max:50',
                'pincode' => 'required|digits:6',
                'mobile' => 'required|digits:10',
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
