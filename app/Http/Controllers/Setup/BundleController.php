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
    public function __construct()
    {
        $this->middleware(['can:access bundles'])->except(['bundles']);
        $this->middleware(['can:create bundles'])->only(['create', 'store']);
        $this->middleware(['can:edit bundles'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $bundles = Bundle::select('id', 'name', 'school_id', 'note', 'active')
            ->with('school:id,name')
            ->when($request->search, function ($query, $search){
                $query->where('name', 'like', '%'. $search . '%');
                $query->orWhere( 'like', '%'. $search . '%');
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

        if ($schools->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'Before adding bundle, add schools and books , then check books are attached to schools and they are active.');
        }
        return Inertia::render('Setup/Bundles/Create', compact('schools'));
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            Bundle::create($request->only('name', 'school_id', 'note', 'active'))->items()->createMany($request->books);
        });
        return redirect(route('bundles.index'))->with('type', 'success')->with('message', 'Bundle added successfully !!');
    }

    public function edit($bundle)
    {
        $bundle = Bundle::select('id','name', 'school_id', 'note', 'active')->with('items:id,bundle_id,class,quantity,book_id')->where('id', $bundle)->first();

        if ($schools->isEmpty()) {
            return redirect()->back()->with('type', 'warning')->with('message', 'Before adding bundle, add schools and books , then check books are attached to schools and they are active.');
        }

        $schools = School::where('active', true)->has('books')->get();
        return Inertia::render('Setup/Bundles/Create', compact('bundle', 'schools'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request, $bundle) {
            $allItems = array();
            $currentItems = array();
            foreach ($bundle->items as $key => $item) {
                $allItems[] = $item->id;
            }
            $bundle->update($bundle->only('name',  'school_id', 'note', 'active'));
            foreach ($request->books as $reqKey => $item) {
                if (isset($item['id'])) {
                    $currentItems[] = $item['id'];
                    BundleBooks::where('id', $item['id'])->update($item);
                }else{
                    $bundle->items()->create($item);
                }
            }

            $deletedItems = array_diff($allItems, $currentItems);
            if ($deletedItems ) {
                BundleBooks::destroy($deletedItems);
            }

        });

        $bundle->update($request->all());
        return redirect(route('bundles.index'))->with('type', 'success')->with('message', 'Bundle updated successfully !!');
    }

    public function bundles()
    {
        return $bundles = Bundle::select('id', 'name', 'city', 'state',  'pincode')
            ->orderBy('name', 'desc')->get();
    }

    private function validateFull($request)
    {
        $tempName = 'Bundle';
        $request->validate(
            [
                'name' => 'required|max:50',
                'school_id' => 'required',
                'books' => 'required'
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'school_id.required' => $tempName .' School is empty.' ,
                'books.required' => ' Add books in bundle.'
            ]
        );
    }
}
