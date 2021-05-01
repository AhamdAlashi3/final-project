<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $this->authorize('viewAny',City::class);
        $cities = City::withCount('admins')->withCount('doctors')->withCount('secrtaries')->withCount('Patients')->paginate(10);

        if($request->expectsJson()){
            return response()->json(['status'=>true,'message'=>'Success','data'=>$cities]);
        }else{
            return response()->view('cms.city.index', ['cities' => $cities]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create',City::class);
        return response()->view('cms.city.create');

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
        $request->validate([
            // 'admin_id'=>'required|string|min:3|max:30',
            'name' => 'required|string|min:3|max:30',
            'active' => 'in:on',
        ], [
            'name.required' => 'City name is required!',
            'name.min' => 'Name must be at least 3 characters'
        ]);
        $city = new City();
        $city->name = $request->get('name');
        $city->active = $request->has('active');
        // $city->admin_id=$request->get('admin_id');
        $isSaved = $city->save();
        if ($isSaved) {
            session()->flash('message', 'City created successfully');
            return redirect()->route('city.create');
        } else {
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
        $this->authorize('view',City::find($id));
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
        $city=City::findOrFail($id);
        $this->authorize('update',$city);
        $cities = City::findOrFail($id);
        return response()->view('cms.city.edit', ['cities' => $cities]);

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
        $cities = City::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'active' => 'in:on'
        ]);

        $cities->name = $request->get('name');
        $cities->active = $request->has('active');
        $isUpdated = $cities->save();
        if ($isUpdated) {
            session()->flash('message', 'City Updated Successfully');
            session()->flash('alert-type', 'alert-success');
        } else {
            session()->flash('message', 'Failed to update City');
            session()->flash('alert-type', 'alert-danger');
        }
        return redirect()->back();
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
        $city = City::findOrFail($id);
        $this->authorize('delete', $city);
        $isDeleted = $city->delete();
        if ($isDeleted) {
            // return redirect()->back();
            return response()->json(['title' => 'Deleted!', 'message' => 'City Deleted Successfully', 'icon' => 'success'], 200);
        } else {
            return response()->json(['title' => 'Failed!', 'message' => 'Delete city failed', 'icon' => 'error'], 400);
        }

    }
}
