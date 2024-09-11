<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
            $this->middleware("throttle:reviews")->only(['store']);
    }
    //控制器的 __construct 方法表示當這個控制器的實例被創建時，將執行這個方法。
    //middleware("throttle:reviews") 意味著只有 reviews 方法（通常是控制器的某個動作）受到 throttle 中間件的約束。

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view("books.reviews.create", ["book"=> $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $data = $request->validate(
            [
                'review' => 'required|min:15',
                'rating' => 'required|min:1|max:5|integer'
            ]
        );
        $book->reviews()->create($data);       
        return redirect()->route('books.show',$book);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
