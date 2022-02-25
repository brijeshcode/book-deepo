<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\School;
use App\Models\Setup\SchoolDocument;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:access schools'])->except(['books', 'bookList', 'bundleList']);
        $this->middleware(['can:create schools'])->only(['create', 'store']);
        $this->middleware(['can:edit schools'])->only(['edit', 'update']);
    }
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
        })->orderBy('id')
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

        if ($warehouses->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'First Add warehouses And make sure atleast one warehouse is active.');
        }
        return Inertia::render('Setup/Schools/Create', compact('warehouses'));
    }

    public function store(Request $request)
    {

        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $school = School::create($request->all());
            $documents = $request->documents;
            foreach ($documents as $key => $document) {
                $documents[$key]['link'] = $this->uploadSchoolDoc($document['link'], $school->id, $document['title']);
            }
            $school->documents()->createMany($documents);
        });

        return redirect(route('schools.index'))->with('type', 'success')->with('message', 'School added successfully !!');
    }

    public function show($id)
    {
        //
    }

    public function edit(School $school)
    {
        $warehouses = Warehouse::select('id', 'name', 'city', 'state', 'pincode')->where('active', 1)->orderBy('name')->get();

        if ($warehouses->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'First Add warehouses And make sure atleast one warehouse is active.');
        }

       $school = $school->load('documents:id,school_id,title,link,note')->only('id',  'name', 'email', 'address', 'city', 'state', 'mobile', 'warehouse_id', 'contact_person', 'pincode', 'note', 'active', 'documents');
        return Inertia::render('Setup/Schools/Create', compact('school', 'warehouses'));
    }

    public function update(Request $request, School $school)
    {
        // dd($request->all());
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $school) {
            $school->update($request->all());
            $oldDocs = array();
            foreach ($school->documents as $key => $document) {
                $oldDocs[$document->id] = $document->id;
            }
            $docs = $request->documents;

            foreach ($docs as $key => $doc) {
                if (isset($doc['id'])) {
                    $schoolDoc = SchoolDocument::whereId($doc['id'])->first();
                    $schoolDoc->title = $doc['title'];
                    $schoolDoc->note = $doc['note'];
                    $schoolDoc->link = $this->uploadSchoolDoc($doc['link'], $school->id, $doc['title']);
                    $schoolDoc->save();
                    unset($oldDocs[$doc['id']]);
                    unset($docs[$key]);
                }
            }

            if (!empty($oldDocs)) {
                SchoolDocument::destroy($oldDocs);
            }

            if (count($docs) > 0) {
                foreach ($docs as $key => $doc) {
                    $docs[$key]['link'] = $this->uploadSchoolDoc($doc['link'], $school->id, $doc['title']);
                }
                $school->documents()->createMany($docs);
            }

        });
        return redirect(route('schools.index'))->with('type', 'success')->with('message', 'School updated successfully !!');
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

    private function uploadSchoolDoc($docPath, $schoolId, $title)
    {
        if(gettype($docPath) == 'string' || is_null($docPath)){
            return $docPath;
        }
        $imageName = $title . '_' .time().'.'.$docPath->extension();
        $location = 'SchoolDoc/'. $schoolId ;
        return Storage::url($docPath->storeAs($location, $imageName, 'public'));

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

    public function bookList(School $school)
    {
        return $books = $school->books()->select('id','name', 'quantity', 'sku_no' ,'class','subject','publisher_id', 'warehouse_id')
        ->with('warehouse:id,name,city,state,email,pincode,mobile,contact_person', 'publisher:id,name,email,contact_person,mobile', 'suppliers:id,name,email,contact_person,mobile')->get();
    }

    public function bundleList(School $school)
    {
        return $school->bundles()
            ->with('items:id,book_id,bundle_id,quantity', 'items.book:id,name,quantity,cost,class,subject')
            ->whereActive(true)
            ->get();
    }

    public function books(School $school)
    {
        $books = $school->books()
        ->with('warehouse:id,name,city,state,email,pincode,mobile,contact_person', 'publisher:id,name')
        ->whereActive(true)
        ->paginate(10);
        $school = $school->only('id','name') ;

        return Inertia::render('Setup/Schools/Books' , compact('books', 'school'));
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
                // 'documents.link' => 'required'
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'city.required' => $tempName .' City is empty.' ,
                'state.required' => $tempName .' State is empty.' ,
                'pincode.required' => $tempName .' Pincode is empty.' ,
                'mobile.required' => $tempName .' Moible is empty.',
                'mobile.digits' => $tempName .' Moible# must number and 10 digits long.',
                'email.required' => 'Enter valid Email.',
                // 'documents.link.required' => 'School document link cannot be empty.'
            ]
        );
    }
}
