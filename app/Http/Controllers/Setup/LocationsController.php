<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:access locations'])->except(['locations','warehouses','suppliers','publishers']);
        $this->middleware(['can:create locations'])->only(['create', 'store']);
        $this->middleware(['can:edit locations'])->only(['edit', 'update']);
    }


    public function index(Request $request)
    {
        $locations = Location::select('id', 'name', 'city', 'state',  'pincode', 'active', 'note')
            ->when($request->search, function ($query, $search){
                $query->where('name', 'like', '%'. $search . '%');
                $query->orWhere('city', 'like', '%'. $search . '%');
                $query->orWhere('state', 'like', '%'. $search . '%');
                $query->orWhere('pincode', 'like', '%'. $search . '%');
                $query->orWhere('note', 'like', '%'. $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(4)
            ->withQueryString()
            ;
        return Inertia::render('Setup/Locations/Index' , compact('locations'));
    }

    public function create(Request $request)
    {
        return Inertia::render('Setup/Locations/Create');
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        Location::create($request->all());
        return redirect(route('locations.index'))->with('type', 'success')->with('message', 'Location added successfully !!');
    }

    public function edit(Location $location)
    {
        $location = $location->only('id','name', 'email', 'city', 'state', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Locations/Create', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $this->validateFull($request);
        $location->update($request->all());
        return redirect(route('locations.index'))->with('type', 'success')->with('message', 'Location updated successfully !!');
    }

    public function locations()
    {
        return Location::select('id', 'name', 'city', 'state',  'pincode')->whereActive(1)
            ->orderBy('name', 'desc')->get();
    }


    public function warehouses($location_id)
    {
        return Warehouse::select('id', 'name')->where('location_id' , $location_id)->whereActive('1')->get();
    }

    public function publishers($location_id)
    {
        return Publisher::select('id', 'name')->where('location_id' , $location_id)->whereActive('1')->get();
    }

    public function suppliers($location_id)
    {
        return Supplier::select('id', 'name')->where('location_id' , $location_id)->whereActive('1')->get();
    }

    private function validateFull($request)
    {
        $tempName = 'Location';
        $request->validate(
            [
                'name' => 'required|max:50',
                'city' => 'required|max:50',
                'state' => 'required|max:50',
                'pincode' => 'required|digits:6'
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'city.required' => $tempName .' City is empty.' ,
                'state.required' => $tempName .' State is empty.' ,
                'pincode.required' => $tempName .' Pincode is empty.'
            ]
        );
    }
}
