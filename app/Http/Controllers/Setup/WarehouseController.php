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

    public function index(Request $request)
    {
        /*$where = array();
        if ($request->search_location_id) {
            $where[] = ['location_id', $request->search_location_id];
            if ($request->search) {
                $where[] = ['name',  'like', '%'. $request->search . '%' ];
            }
        }else{
            if ($request->search) {
                $where[] = ['name', 'like', '%'. $request->search . '%' ];
                $where[] = ['contact_person', 'like', '%'. $request->search . '%' ];
                $where[] = ['email', 'like', '%'. $request->search . '%' ];
                $where[] = ['city', 'like', '%'. $request->search . '%' ];
                $where[] = ['state', 'like', '%'. $request->search . '%' ];
                $where[] = ['pincode', 'like', '%'. $request->search . '%' ];
                $where[] = ['mobile', 'like', '%'. $request->search . '%' ];
                $where[] = ['note', 'like', '%'. $request->search . '%' ];
            }
        }

        $warehouses = Warehouse::with('location')->orderBy('id', 'desc')
        ->orWhere($where)
        ->paginate(10)->withQueryString()->through(fn($warehouse) => [
            'id' => $warehouse->id,
            'name' => $warehouse->name,'city' => $warehouse->city,
            'state' => $warehouse->state, 'contact_person' => $warehouse->contact_person,
            'pincode' => $warehouse->pincode, 'email' => $warehouse->email, 'note' => $warehouse->note,
            'mobile'=> $warehouse->mobile, 'active' => $warehouse->active,
            'location' => $warehouse->location->name
        ]);*/

        $warehouses = Warehouse::with('location')->orderBy('id', 'desc')
        /*->when($request->search_location_id, function ($tesm, $search_location_id){
            $tesm->where('location_id', $search_location_id );
        })*/
        ->when($request->search, function ($query, $search){
            $query->orWhere('name', 'like', '%'. $search . '%');
            $query->orWhere('contact_person', 'like', '%'. $search . '%');
            $query->orWhere('email', 'like', '%'. $search . '%');
            $query->orWhere('city', 'like', '%'. $search . '%');
            $query->orWhere('state', 'like', '%'. $search . '%');
            $query->orWhere('pincode', 'like', '%'. $search . '%');
            $query->orWhere('address', 'like', '%'. $search . '%');
            $query->orWhere('mobile', 'like', '%'. $search . '%');
            $query->orWhere('note', 'like', '%'. $search . '%');
        })
        ->paginate(10)->withQueryString()->through(fn($warehouse) => [
            'id' => $warehouse->id,
            'name' => $warehouse->name,'city' => $warehouse->city,
            'state' => $warehouse->state, 'contact_person' => $warehouse->contact_person,
            'pincode' => $warehouse->pincode, 'email' => $warehouse->email, 'note' => $warehouse->note,
            'mobile'=> $warehouse->mobile, 'active' => $warehouse->active,
            'location' => $warehouse->location->name, 'address' => $warehouse->address
        ]);
        return Inertia::render('Setup/Warehouses/Index' , compact('warehouses'));
    }

    public function create()
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();

        if ($locations->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'First Add locations And make sure atleast one location is active.');
        }
        return Inertia::render('Setup/Warehouses/Create', compact('locations'));
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        Warehouse::create($request->all());
        return redirect(route('warehouses.index'))->with('type', 'success')->with('message', 'Warehouse added successfully !!');
    }

    public function show($id)
    {
        //
    }

    public function edit(Warehouse $warehouse)
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();

        if ($locations->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'First Add locations And make sure atleast one location is active.');
        }
        $warehouse = $warehouse->only('id','name', 'address', 'email', 'city', 'state', 'mobile', 'location_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Warehouses/Create', compact('warehouse', 'locations'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $this->validateFull($request);
        $warehouse->update($request->all());
        return redirect(route('warehouses.index'))->with('type', 'success')->with('message', 'Warehouse updated successfully !!');
    }

    public function destroy($id)
    {
        //
    }

    public function schools($warehouse_id)
    {
        return School::select('id', 'name')->where('warehouse_id' , $warehouse_id)->whereActive('1')->get();
    }

    private function validateFull($request)
    {
        $tempName = 'Warehouse';
        $request->validate(
            [
                'name' => 'required|max:50',
                'city' => 'required|max:50',
                'address' => 'required',
                'state' => 'required|max:50',
                'pincode' => 'required|digits:6',
                'mobile' => 'required|digits:10',
                'email' => 'email',
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'address.required' => $tempName .' Address is empty.' ,
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
