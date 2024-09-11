<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
        $title = $request->input('title');
        $filter = $request->input('filter','');
        
        $books = Book::when($title, fn($query, $title) => $query->title($title));
        
        //PHP 8 中的 match 表達式的代碼。match 表達式是一種更簡潔和可讀的方式來替代 switch 语句
        // 在 match 表達式的每個分支中，你對 $books 執行了一些方法，這些方法都是你在 Book 模型中定義的範圍（Scope）方法
        // 這些範圍方法實際上返回的還是一個 Eloquent 查詢構建器實例，所以你可以在其後串鏈調用更多的方法
        $books = match ($filter) {
                'popular_last_month' => $books->PopularLastMonth(),
                'popular_last_6months' => $books-> PopularLast6Months(),
                'highest_rated_last_month' => $books-> HighestRatedLastMonth(),
                'highest_rated_last_6months' => $books-> HighestRatedLast6Months(),
                 default => $books->latest()->withAvgRating()->withReviewCount()
        };
        // $books = $books->get();
        $cacheKey = 'books:'. $title .':'. $filter ;
        //  'books:'：一個固定的前綴，用來區分不同類型的緩存項目。
        // $title：書籍的標題。這是查詢的一部分，確保不同標題的書籍有不同的緩存項目。
        // ':'：用來分隔不同的緩存鍵組成部分。
        // $filter：篩選條件。確保使用不同篩選條件的查詢有不同的緩存項目。
        
         $books = cache()->remember( $cacheKey, 3600 ,fn() => $books->get());
    
        return view('books.index',['books'=> $books]);
    }

  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id){
        $cacheKey = 'book:'. $id;
        $book = cache()->remember( $cacheKey,3600 ,fn()=>
        Book::with([
            'reviews' =>fn($query) => $query->latest()
        ])->withAvgRating()->withReviewCount()->findOrfail($id));

        return view('books.show',['book'=> $book]);
     }
    //WithAvgRating()、WithReviewCount()要對models使用!!
    //load()只對已加載的moedel有用 


    // public function show(Book $book)
    // {
    //     $chacheKey = 'book:'.$book->id;
    //     $book->withAvgRating()->withReviewCount();
    //     $book = cache()->remember( $chacheKey,3600 ,fn() =>$book->load([
    //         'reviews' => fn($query) => $query->latest()
    //     ]));      
    //     return view('books.show',
    //     [ 'book'=> $book ]);
    // }

   


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
