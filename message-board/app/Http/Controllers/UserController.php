<?php

namespace App\Http\Controllers;

use App\Facades\CounterFacade;
use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

   public function __construct()
   {
    $this->middleware("auth");
    $this->authorizeResource(User::class, 'user');    
   }
   //authorizeResource這個方法的作用是基於慣例，Model vs UserPolicy，第二個參數為web的名稱
   //將 CRUD 操作映射到相應的授權方法。當你使用這個方法時，Laravel 會自動調用授權策略（Policy）中的相應方法，以確定當前用戶是否擁有執行該操作的權限。
   
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
    public function show(User $user)
    {           

        return view('users.show',[
        'user'=>$user,
        'counter' =>CounterFacade::increment("user-{$user->id}")]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request, User $user)
    {
       if($request->hasFile('avatar')){
        $path = $request->file('avatar')->store('avatars');

        if($user->image){
            $user->image->path = $path;
            $user->image->save();   
        }else{
            $user->image()->save(
                Image::make(['path' => $path])
            );
        }
       }

       $user->locale = $request->get('locale');
       $user->save();


       return redirect()
       ->back()
       ->withStatus('Profile was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
