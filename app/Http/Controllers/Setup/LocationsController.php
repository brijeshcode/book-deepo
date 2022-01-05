<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationsController extends Controller
{
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
        return redirect(route('locations'))->with('type', 'success')->with('message', 'Location added successfully !!');
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
        return redirect(route('locations'))->with('type', 'success')->with('message', 'Location updated successfully !!');
    }

    public function locations()
    {
        return $locations = Location::select('id', 'name', 'city', 'state',  'pincode')
            ->orderBy('name', 'desc')->get();
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
