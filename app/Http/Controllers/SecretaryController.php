<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Secretary;
use App\Models\Secrtary;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $secretaries=Secrtary::with('cities')->paginate(10);
        return response()->view('cms.Secretary.index',['secretaries'=>$secretaries]);
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
        return response()->view('cms.Secretary.create',['cities'=>$cities]);
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
            'name' =>'required|string|min:3|max:30',
            'city_id' => 'required|integer|exists:cities,id',
            'gender' => 'required|in:M,F|string',
            'active' => 'required|boolean'
        ]);
        if(!$validator->fails()){
            $secretaries = new Secrtary();
            $secretaries->name   = $request->get('name');
            $secretaries->city_id = $request->get('city_id');
            $secretaries->gender = $request->get('gender');
            $secretaries->active = $request->has('active');
            $isSaved = $secretaries->save();
            if ($isSaved) {
            }
            return response()->json(['message' => $isSaved ? 'Secretary created successfully' : 'Failed to create Secretary!'], $isSaved ? 201 : 400);
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
        $secretaries=Secrtary::findOrFail($id);
        $cities=City::where('active',true)->get();
        return response()->view('cms.Secretary.edit',['secretaries'=>$secretaries,'cities'=>$cities]);
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
            'name' =>'required|string|min:3|max:30',
            'city_id' => 'required|integer|exists:cities,id',
            'gender' => 'required|in:M,F|string',
            'active' => 'required|boolean'
        ]);
        if(!$valodator->fails()){
        $secretaries =Secrtary::findOrFail($id);
        $secretaries->name    = $request->get('name');
        $secretaries->city_id = $request->get('city_id');
        $secretaries->gender = $request->get('gender');
        $secretaries->active = $request->has('active');
        $isUpdated = $secretaries->save();
        return response()->json(['message' => $isUpdated ? 'Secratary updated successfully' : 'Failed to updated Secratary!'], $isUpdated ? 201 : 400);
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
        $isDeleted = Secrtary::destroy($id);
        if($isDeleted){
            // return redirect()->back();
            return response()->json(['title'=>'Deleted!','message'=>'The secretary is deleted!','icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!','message'=>'The secretary is failed!','icon'=>'error'],400);
        }
    }
}
