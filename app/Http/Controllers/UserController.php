<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::paginate(10);
        return response()->view('cms.User.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator=Validator($request->all(),[
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'city' => 'required|string|min:3|max:30',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$validator->fails()){
            $admins = new User();
            $admins->first_name   = $request->get('first_name');
            $admins->last_name   = $request->get('last_name');
            $admins->city = $request->get('city');
            $admins->DoB = $request->get('DoB');
            $admins->phone   = $request->get('phone');
            $admins->email = $request->get('email');
            $admins->gender = $request->get('gender');
            $admins->password = Hash::make('user2020');
            $isSaved = $admins->save();
            if ($isSaved) {
            }
              return response()->json(['message' => $isSaved ? 'User created successfully' : 'Failed to create user!'], $isSaved ? 201 : 400);
            }else {
             return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users=User::findOrFail($id);
        return response()->view('cms.User.edit',['users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $valodator=Validator($request->all(),[
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'city' => 'required|string|min:3|max:30',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$valodator->fails()){
        $users =User::findOrFail($id);
        $users->first_name    = $request->get('first_name');
        $users->last_name   = $request->get('last_name');
        $users->city    = $request->get('city');
        $users->DoB    = $request->get('DoB');
        $users->phone   = $request->get('phone');
        $users->email = $request->get('email');
        $users->gender = $request->get('gender');
        $users->password = Hash::make('user2020');
        $isUpdated = $users->save();
        return response()->json(['message' => $isUpdated ? 'User updated successfully' : 'Failed to updated user!'], $isUpdated ? 201 : 400);
        }else{
        return response()->json(['message'=>$valodator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $isDeleted = User::destroy($id);
        if($isDeleted){
            // return redirect()->back();
            return response()->json(['title'=>'Deleted!','message'=>'The user is deleted!','icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!','message'=>'The user is failed!','icon'=>'error'],400);
        }
    }
}
