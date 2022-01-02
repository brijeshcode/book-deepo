<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publishers = Publisher::with('location')->orderBy('id', 'desc')
         ->when($request->search, function ($query, $search){
            $query->where('name', 'like', '%'. $search . '%');
            $query->orWhere('contact_person', 'like', '%'. $search . '%');
            $query->orWhere('email', 'like', '%'. $search . '%');
            $query->orWhere('city', 'like', '%'. $search . '%');
            $query->orWhere('state', 'like', '%'. $search . '%');
            $query->orWhere('pincode', 'like', '%'. $search . '%');
            $query->orWhere('mobile', 'like', '%'. $search . '%');
            $query->orWhere('note', 'like', '%'. $search . '%');
        })
        ->paginate(10)->withQueryString()->through(fn($publisher) => [
            'id' => $publisher->id,
            'name' => $publisher->name,'city' => $publisher->city,'state' => $publisher->state, 'contact_person' => $publisher->contact_person,
            'pincode' => $publisher->pincode, 'email' => $publisher->email, 'note' => $publisher->note,
            'mobile'=> $publisher->mobile, 'active' => $publisher->active,
            'location' => $publisher->location->name
        ]);
        return Inertia::render('Setup/Publishers/Index' , compact('publishers'));
    }

    public function create()
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        return Inertia::render('Setup/Publishers/Create', compact('locations'));
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        Publisher::create($request->all());
        return redirect(route('publishers'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Publisher $publisher)
    {
        $locations = Location::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();
        $publisher = $publisher->only('id','name', 'email', 'city', 'state', 'mobile', 'location_id', 'contact_person', 'pincode', 'note', 'active');
        return Inertia::render('Setup/Publishers/Create', compact('publisher', 'locations'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $this->validateFull($request);
        $publisher->update($request->all());
        return redirect(route('publishers'));
    }

    public function destroy($id)
    {
        //
    }

    public function books($publisher)
    {
        return Publisher::select('id', 'name')->with('books:id,publisher_id,name,class,subject,author_name')->where('id' , $publisher)->first();

        // return response()->json($books);
    }
    
    private function validateFull($request)
    {
        $tempName = 'Publisher';
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
                'name.required' => $tempName .' Name is empty.',
                'city.required' => $tempName .' City is empty.',
                'state.required' => $tempName .' State is empty.',
                'pincode.required' => $tempName .' Pincode is empty.',
                'mobile.required' => $tempName .' Moible is empty.',
                'mobile.digits' => $tempName .' Moible number must be 10 digits.',
                'email.required' => 'Enter valid Email.'
            ]
        );
    }
}
