<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use App\Models\Setup\School;
use App\Models\Setup\Supplier;
use App\Models\Setup\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::select('id', 'warehouse_id', 'school_id' , 'supplier_id' ,'publisher_id', 'sku_no','cost', 'subject', 'name', 'author_name', 'description', 'class', 'quantity', 'note', 'active')
            ->with(
                'school:id,name,city,state,pincode,contact_person,mobile,active,email',
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
        $warehouses = Warehouse::select('id', 'name')->where('active', 1)->orderBy('name')->get();

        return Inertia::render('Setup/Books/Create', compact('suppliers','publishers', 'warehouses') );
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
        // dd($request);
        Book::create($request->all());
        return redirect(route('books'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Book $book)
    {
        $suppliers = Supplier::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $publishers = Publisher::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $warehouses = Warehouse::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $book = $book->only('id','name', 'sku_no', 'cost', 'quantity', 'school_id', 'warehouse_id', 'author_name','subject', 'supplier_id', 'publisher_id', 'description', 'class', 'note', 'active');

        return Inertia::render('Setup/Books/Create', compact('book', 'suppliers', 'publishers', 'warehouses'));
    }

    public function update(Request $request, Book $book)
    {
        $this->validateUpdate($request , $book);
        $book->update($request->all());
        return redirect(route('books'));
    }

    public function destroy($id)
    {
        //
    }

    private function validateFull($request)
    {
        $tempName = 'Book';
        $request->validate(
            [
                'name' => 'required|max:150',
                'publisher_id' => 'required',
                'subject' => 'required',
                'class' => 'required',
                'warehouse_id' => 'required',
                'school_id' => 'required',
                'sku_no' => 'required|unique:books|min:3'
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

    private function validateUpdate($request, $book)
    {
        $tempName = 'Book';
        $request->validate(
            [
                'name' => 'required|max:150',
                'publisher_id' => 'required',
                'subject' => 'required',
                'class' => 'required',
                'warehouse_id' => 'required',
                'school_id' => 'required',
                'sku_no' => ['required','min:3',Rule::unique('books')->ignore($book->id)]
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
