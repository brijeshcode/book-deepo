<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SchoolSample;
use App\Models\Orders\SchoolSampleItem;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SampleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:access samples']);
        $this->middleware(['can:create samples'])->only(['create', 'store']);
        $this->middleware(['can:edit samples'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $samples = SchoolSample::with('school:id,name')->select('id', 'date' , 'school_id', 'quantity', 'note' )->orderBy('id', 'desc')->paginate(10);
        return Inertia::render('Order/Sample/Index', compact('samples'));
    }

    public function create(Request $request)
    {

        $schools = School::select('id', 'name')->whereActive(1)->orderBy('name')->get();
        if ($schools->isEmpty())
            return redirect()->back()->with('type', 'warning')->with('message', 'Add schools and make sure they are active');

        $publishers = Publisher::select('id','name')->whereActive(1)->orderBy('name')->get();
        if ($publishers->isEmpty())
            return redirect()->back()->with('type', 'warning')->with('message', 'Add publishers and make sure they are active');

        return Inertia::render('Order/Sample/Create', compact('schools', 'publishers'));
    }

    public function edit($sample)
    {
        $sample = SchoolSample::select('id', 'date', 'school_id', 'quantity' ,'note' )
                ->with('items:id,school_sample_id,publisher_id,class,subject,name,quantity,quantity')
                ->where('id', $sample)->first();
        $schools = School::select('id', 'name')->whereActive(1)->orderBy('name')->get();
        $publishers = Publisher::select('id','name')->whereActive(1)->orderBy('name')->get();

        return Inertia::render('Order/Sample/Create', compact('schools', 'sample', 'publishers'));
    }

    public function show(SchoolSample $sample)
    {
        $sample = $sample->load( 'school:id,name,address,city,state,pincode,warehouse_id' , 'school.warehouse' , 'items:id,school_sample_id,name,quantity,class,subject,publisher_id', 'items.publisher:id,name')
        ->only('id', 'date', 'school_id', 'quantity' ,'note', 'school', 'items');

        return Inertia::render('Order/Sample/Show', compact('sample'));
    }


    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            SchoolSample::create($request->only('school_id', 'date','quantity','note'))->items()->createMany($request->items);
        });

        return redirect(route('samples.index'))->with('type', 'success')->with('message', 'Sample generated successfully !!');
    }


    public function update(Request $request, SchoolSample $sample)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $sample) {
            $allItems = array();
            $currentItems = array();
            foreach ($sample->items as $key => $item) {
                $allItems[] = $item->id;
            }
            $sample->update($request->only('school_id', 'date','quantity','note'));

            foreach ($request->items as $reqKey => $item) {
                if (isset($item['id'])) {
                    $currentItems[] = $item['id'];
                    SchoolSampleItem::where('id', $item['id'])->update($item);
                }else{
                    $sample->items()->create($item);
                }
            }

            $deletedItems = array_diff($allItems, $currentItems);
            if ($deletedItems ) {
                SchoolSampleItem::destroy($deletedItems);
            }
        });

        return redirect(route('samples.index'))->with('type', 'success')->with('message', 'Sample updated successfully !!');
    }


    private function validateFull($request)
    {
        $tempName = 'School Sample';
        $request->validate(
            [
                'school_id' => 'required',
                'date' => 'required',
                'items' => 'required'
            ],
            [
                'school_id.required' => 'School is not selected.',
                'date.required' => 'date is not selected.',

                'items.required' => "No item added"

            ]
        );
    }
}
