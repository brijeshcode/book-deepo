<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Location;
use App\Models\Setup\School;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::with('location')->orderBy('id', 'desc')->paginate(10)->through(fn($warehouse) => [
            'id' => $warehouse->id,
            'name' => $warehouse->name,'city' => $warehouse->city,'state' => $warehouse->state, 'contact_person' => $warehouse->contact_person,
            'pincode' => $warehouse->pincode, 'email' => $warehouse->email, 'note' => $warehouse->note,
            'mobile'=> $warehouse->mobile, 'active' => $warehouse->active,
            'location' => $warehouse->location->name
        ]);
        return Inertia::render('Setup/Warehouses/Index' , compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        return Inertia::render('Setup/Warehouses/Create', compact('locations'));
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
        Warehouse::create($request->all());
        return redirect(route('warehouses'));
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
    public function edit(Warehouse $warehouse)
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        $warehouse = $warehouse->only('id','name', 'email', 'city', 'state', 'mobile', 'location_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Warehouses/Create', compact('warehouse', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $this->validateFull($request);
        $warehouse->update($request->all());
        return redirect(route('warehouses'));
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

    public function schools($warehouse_id)
    {
        return School::select('id', 'name')->where('warehouse_id' , $warehouse_id)->get();
    }

    private function validateFull($request)
    {
        $tempName = 'Warehouse';
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
