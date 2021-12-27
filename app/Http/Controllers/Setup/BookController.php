<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate(10)->through(fn($book) => [
            'id' => $book->id,
            'name' => $book->name,'author_name' => $book->author_name,'description' => $book->description,
            'class' => $book->class, 'note' => $book->note,
            'subject' => $book->subject,
            'active' => $book->active
        ]);
        return Inertia::render('Setup/Books/Index' , compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $publishers = Publisher::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        return Inertia::render('Setup/Books/Create', compact('suppliers','publishers') );
    }

    public function store(Request $request)
    {
        $this->validateFull($request);
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
        $book = $book->only('id','name', 'author_name','subject', 'supplier_id', 'publisher_id', 'description', 'class', 'note', 'active');
        return Inertia::render('Setup/Books/Create', compact('book', 'suppliers', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $this->validateFull($request);
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
            ],
            [
                'name.required' => $tempName .' Name is empty.' ,
                'name.max' => $tempName .'Name must be smaller then 150 characters' ,
            ]
        );
    }
}
