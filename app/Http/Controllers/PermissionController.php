<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permissions=Permission::paginate(10);
        return response()->view('cms.Spatie.permissions.index',['permissions'=>$permissions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.Spatie.permissions.create');

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
            'guard'=>'required|string|in:admin',
            'name'=>'required|string|min:3',
        ]);
        if(!$validator->fails()){
            $permnissions=new Permission();
            $permnissions->name=$request->get('name');
            $permnissions->guard_name=$request->get('guard');
            $isSaved=$permnissions->save();
            return response()->json(['message'=>$isSaved ? 'Permnission created succssefully' : 'Failed created permnission !'],$isSaved ? 201 : 400);
        }else{
            return response()->json(['message'=>'Failed to create permnission !'],400);
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
        $permissions=Permission::findById($id,'admin');
        return response()->view('cms.Spatie.permissions.edit',['permissions'=>$permissions]);
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
        $validator=Validator($request->all(),[
            'guard'=>'required|string|in:admin',
            'name'=>'required|string|min:3',
        ]);
        if(!$validator->fails()){
            $permissions=Permission::findOrFail($id);
            $permissions->name=$request->get('name');
            $permissions->guard_name=$request->get('guard');
            $isUpdated=$permissions->save();
            return response()->json(['message'=>$isUpdated ? 'Permission updated succssefully' : 'Failed updated Permission !'],$isUpdated ? 201 : 400);
        }else{
            return response()->json(['message'=>'Failed to create Permission !'],400);
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
        $isDeleted=Permission::destroy($id);
        if ($isDeleted) {
            return response()->json(['title' => 'Deleted!', 'message' => 'Permission Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete Permission failed', 'icon' => 'error'], 400);
        }
    }
}
