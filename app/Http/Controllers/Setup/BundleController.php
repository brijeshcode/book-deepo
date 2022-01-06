<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Bundle;
use App\Models\Setup\BundleBooks;
use App\Models\Setup\School;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BundleController extends Controller
{
    public function index(Request $request)
    {
        $bundles = Bundle::select('id', 'name', 'class', 'school_id', 'note', 'active')
            ->with('school')
            ->when($request->search, function ($query, $search){
                $query->where('name', 'like', '%'. $search . '%');
                $query->orWhere('class', 'like', '%'. $search . '%');
                $query->orWhere('note', 'like', '%'. $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ;
        return Inertia::render('Setup/Bundles/Index' , compact('bundles'));
    }

    public function create(Request $request)
    {
        $schools = School::where('active', true)->has('books')->get();
        return Inertia::render('Setup/Bundles/Create', compact('schools'));
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            Bundle::create($request->only('name', 'class', 'school_id', 'note', 'active'))->items()->createMany($request->books);
        });
        return redirect(route('bundles'))->with('type', 'success')->with('message', 'Bundle added successfully !!');
    }

    public function edit($bundle)
    {
        $bundle = Bundle::select('id','name', 'class', 'school_id', 'note', 'active')->with('items:id,bundle_id,class,quantity,book_id')->where('id', $bundle)->first();
        $schools = School::where('active', true)->has('books')->get();
        return Inertia::render('Setup/Bundles/Create', compact('bundle', 'schools'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $bundle) {
            $bundle->update($bundle->only('name', 'class', 'school_id', 'note', 'active'));
            foreach ($request->books as $reqKey => $item) {
                if (isset($item['id'])) {
                    BundleBooks::where('id', $item['id'])->update($item);
                }else{
                    $bundle->items()->create($item);
                }
            }
        });

        $bundle->update($request->all());
        return redirect(route('bundles'))->with('type', 'success')->with('message', 'Bundle updated successfully !!');
    }

    public function bundles()
    {
        return $bundles = Bundle::select('id', 'name', 'city', 'state',  'pincode')
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
        $tempName = 'Bundle';
        $request->validate(
            [
                'name' => 'required|max:50',
                'school_id' => 'required',
                'class' => 'required',
                'books' => 'required'
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'school_id.required' => $tempName .' School is empty.' ,
                'class.required' => $tempName .' Class is empty.' ,
                'books.required' => ' Add books in bundle.'
            ]
        );
    }
}
