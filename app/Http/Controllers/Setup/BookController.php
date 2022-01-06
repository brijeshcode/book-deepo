<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\Location;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::select('id', 'publisher_id', 'warehouse_id', 'sku_no','cost', 'subject', 'name', 'author_name', 'description', 'class', 'quantity', 'note', 'active')
            ->with(
                // 'schools',
                'schools:id,name,city,state,pincode,contact_person,mobile,active,email',
                // 'school:id,name,city,state,pincode,contact_person,mobile,active,email',
                'warehouse:id,name,city,state,pincode,contact_person,mobile,active,email')
            ->when($request->search, function ($query, $search){
            $query->where('name', 'like', '%'. $search . '%');
            $query->orWhere('author_name', 'like', '%'. $search . '%');
            $query->orWhere('class', 'like', '%'. $search . '%');
            $query->orWhere('description', 'like', '%'. $search . '%');
            $query->orWhere('quantity', 'like', '%'. $search . '%');
            $query->orWhere('sku_no', 'like', '%'. $search . '%');
            $query->orWhere('note', 'like', '%'. $search . '%');
        })
        ->paginate(10)->withQueryString();

        return Inertia::render('Setup/Books/Index' , compact('books'));
    }

    public function list()
    {
        return Book::select( 'id', 'name', 'author_name' ,'description', 'class' , 'note', 'subject'
        )->where('active' , true)->orderBy('name')->get();
    }

    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $publishers = Publisher::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $warehouses = Warehouse::select('id', 'name')->where('active', 1)->has('schools')->orderBy('name')->get();
        $locations = Location::select('id', 'name')->where('active', 1)->has('publishers')->has('warehouses')->orderBy('name')->get();
        $book = Warehouse::select('id', 'name')->where('active', 1)->orderBy('name')->get();

        return Inertia::render('Setup/Books/Create', compact('suppliers', 'locations','publishers', 'warehouses') );
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        \DB::transaction(function() use ($request) {
            $book = Book::create($request->book);
            $book->schools()->sync(array_values($request->schools));
            $book->suppliers()->sync(array_values($request->suppliers));
        });
        return redirect(route('books'))->with('type', 'success')->with('message', 'Book added successfully !!');
    }



    public function edit($book)
    {
        $suppliers = Supplier::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $publishers = Publisher::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $warehouses = Warehouse::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $locations = Location::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $book = Book::select('id','name', 'sku_no', 'cost', 'quantity', 'warehouse_id','location_id', 'author_name','subject', 'publisher_id', 'description', 'class', 'note', 'active')
        ->with('schools:id,name', 'suppliers:id,name')->where('id', $book)->first();
        return Inertia::render('Setup/Books/Create', compact('book', 'suppliers', 'publishers', 'warehouses', 'locations'));
    }

    public function update(Request $request, Book $book)
    {
        $this->validateUpdate($request , $book);

        \DB::transaction(function() use ($request, $book) {
            $book->schools()->sync(array_values($request->schools));
            $book->suppliers()->sync(array_values($request->suppliers));
            $book = $book->update($request->book);
        });
        return redirect(route('books'))->with('type', 'success')->with('message', 'Book updated successfully !!');
    }

    public function destroy($id)
    {
        //
    }

    private function validateFull($request)
    {
        // dd($request->book['name']);
        $tempName = 'Book';
        $request->validate(
            [
                'book.name' => 'required|max:150',
                'book.publisher_id' => 'required',
                'book.location_id' => 'required',
                'book.warehouse_id' => 'required',
                'book.subject' => 'required',
                'book.class' => 'required',
                'schools' => 'required',
                'book.sku_no' => 'required|unique:books,sku_no|min:3'
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'location_id.required' => $tempName .' Location is empty.' ,
                'name.max' => $tempName .'Name must be smaller then 150 characters' ,
                'publisher_id.required' => 'Please select publisher.' ,
                'warehouse_id.required' => 'Please select warehouses.' ,
                'schools.required' => 'Add school for this book.' ,
                'class.required' => $tempName .' Class is empty.' ,
                'subject.required' => $tempName .' Subject is empty.' ,
                'sku_no.required' => 'SKU number cannot be empty.',
                'sku_no.min' => 'SKU number must be atleast 3 characters.',
                'sku_no.unique' => 'This SKU number is already in system.'
            ]
        );
    }

    private function validateUpdate($request, $book)
    {
        $tempName = 'Book';
        $request->validate(
            [
                'book.name' => 'required|max:150',
                'book.publisher_id' => 'required',
                'book.location_id' => 'required',
                'book.warehouse_id' => 'required',
                'book.subject' => 'required',
                'book.class' => 'required',
                'schools' => 'required',
                'book.sku_no' => ['required','min:3'],
                'sku_no' => [Rule::unique('books')->ignore($book->id)],
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'name.max' => $tempName .'Name must be smaller then 150 characters' ,
                'publisher_id.required' => 'Please select publisher.' ,
                'warehouse_id.required' => 'Please select warehouses.' ,
                'school_id.required' => 'Please select school.' ,
                'class.required' => $tempName .' Class is empty.' ,
                'subject.required' => $tempName .' Subject is empty.' ,
                'sku_no.required' => 'SKU number cannot be empty.',
                'sku_no.min' => 'SKU number must be atleast 3 characters.',
                'sku_no.unique' => 'This SKU number is already in system.'
            ]
        );
    }
}
