<?php
use App\Http\Requests\TaskRequest;
use \App\Models\Task;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('task.index');
});

Route::get('/tasks', function () {
   return view("index",[
    'tasks'=>\App\Models\Task::latest()->orderBy('created_at','desc')->paginate(10),
   ]);
})->name('task.index');

Route::view('/tasks/create','create')->name('task.create');

Route::get('/tasks/{task}/edit', function (Task $task)  {

  return view('edit',['task'=>$task]);
})->name('task.edit');  

Route::get('/tasks/{task}', function (Task $task)  {
    //碼使用 Laravel 中的 collect 函數，通常用於將數組轉換為集合，然後使用 firstwhere 方法查找集合中第一個符合指定條件的元素
    // $task = collect($tasks)->firstwhere('id', $id);
    // if(!$task) {
    //     abort(Response::HTTP_NOT_FOUND);
    //     //當這行代碼執行時，它會終止請求的執行，並將 404 響應返回給客戶端
    // }    
    return view('show',['task'=>$task]);
})->name('task.show');  


Route::post('/tasks', function(TaskRequest $request) {
   //dd($request->all());
  //dd 函數用於將變量的值打印並停止腳本的執行

  // $data = $request->validated();
 
  // $task = new Task;
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save();
  
  $task= Task::create($request->validated());

  return redirect()->route('task.show',['task'=>$task->id])->with('success','Task is created successfully!!');
})->name('task.store');


Route::put('/tasks/{task}', function(Task $task ,TaskRequest $request) {
//  $data = $request->validated();
//  $task->title = $data['title'];
//  $task->description = $data['description'];
//  $task->long_description = $data['long_description'];
//  $task->save();

$task->update($request->validated());

 return redirect()->route('task.show',['task'=>$task->id])->with('success','Task update successfully!!');
})->name('task.update');

Route::delete('/tasks/{task}',function(Task $task){
  $task->delete();
  return redirect()->route('task.index')->with('success','Task deleted successfully!!');

})->name('task.destroy');

Route::put('/tasks/{task}/toggle-completed', function (Task $task) {
  $task->toggleComplete();

  return redirect()->back()->with('success','Task updated successfully!');
})->name('task.toggle-complete');

















// Route::get('/xxx',function(){
//     return 'Hello';
// })->name('hello');

// Route::get('/hallo',function(){
//    return redirect()->route('hello');
// });

// Route::get('/greet/{name}',function($name){
//     return 'Hello ' . $name . '!!';
// });
// Route::fallback(function(){
//     return 'still got somewhere!!';});