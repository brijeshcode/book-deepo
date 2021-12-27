<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Location;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::with('location')->orderBy('id', 'desc')->paginate(10)->through(fn($school) => [
            'id' => $school->id,
            'name' => $school->name,'city' => $school->city,'state' => $school->state, 'contact_person' => $school->contact_person,
            'pincode' => $school->pincode, 'email' => $school->email, 'note' => $school->note,
            'mobile'=> $school->mobile, 'active' => $school->active,
            'location' => $school->location->name
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
        $locations = Location::select('id', 'name', 'city', 'state' , 'pincode')->where('active', 1)->orderBy('name')->get();
        return Inertia::render('Setup/Schools/Create', compact('locations'));
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
        return redirect(route('schools'));
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
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        $school = $school->only('id','name', 'email', 'city', 'state', 'mobile', 'location_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Schools/Create', compact('school', 'locations'));
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
        return redirect(route('schools'));
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
                'location_id' => 'required',
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
