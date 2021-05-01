<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins=Admin::withCount('permissions')->with(['cities'])->paginate(10);
        return response()->view('cms.Admin.index',['admins'=>$admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cities=City::where('active',true)->get();
        return response()->view('cms.Admin.create',['cities'=>$cities]);
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
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$validator->fails()){
            $admins = new Admin();
            $admins->city_id = $request->get('city_id');
            $admins->first_name   = $request->get('first_name');
            $admins->last_name   = $request->get('last_name');
            $admins->phone   = $request->get('phone');
            $admins->email = $request->get('email');
            $admins->gender = $request->get('gender');
            $admins->password = Hash::make('ahmad2020');
            $isSaved = $admins->save();
            if ($isSaved) {
            }
              return response()->json(['message' => $isSaved ? 'Admin created successfully' : 'Failed to create admin!'], $isSaved ? 201 : 400);
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
        $admins=Admin::findOrfail($id);
        $cities = City::where('active', true)->get();
        return response()->view('cms.admin.edit', ['admins' => $admins,'cities'=>$cities]);
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
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$valodator->fails()){
        $admins =Admin::findOrFail($id);
        $admins->city_id = $request->get('city_id');
        $admins->first_name    = $request->get('first_name');
        $admins->last_name   = $request->get('last_name');
        $admins->phone   = $request->get('phone');
        $admins->email = $request->get('email');
        $admins->gender = $request->get('gender');
        $admins->password = Hash::make('ahmad2020');
        $isUpdated = $admins->save();
        return response()->json(['message' => $isUpdated ? 'Admin updated successfully' : 'Failed to updated admin!'], $isUpdated ? 201 : 400);
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
        $isDeleted = Admin::destroy($id);
        if($isDeleted){
            // return redirect()->back();
            return response()->json(['title'=>'Deleted!','message'=>'The admin is deleted!','icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!','message'=>'The admin is failed!','icon'=>'error'],400);
        }
    }
}
