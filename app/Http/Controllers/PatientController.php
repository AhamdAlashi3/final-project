<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $patients=Patient::withCount('doctors')->with(['cities'])->paginate(10);
        // $patients=Patient::find(1);
        return response()->view('cms.Patient.index',['patients'=>$patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $doctors=Doctor::where('active',true)->get();
        $cities=City::where('active',true)->get();
        return response()->view('cms.Patient.create',['doctors'=>$doctors,'cities'=>$cities]);
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
            'doctor_id' => 'required|integer|exists:doctors,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'city_id' => 'required|integer|exists:cities,id',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$validator->fails()){
            $patients = new Patient();
            $patients->doctor_id = $request->get('doctor_id');
            $patients->first_name   = $request->get('first_name');
            $patients->last_name   = $request->get('last_name');
            $patients->city_id = $request->get('city_id');
            $patients->DoB = $request->get('DoB');
            $patients->phone   = $request->get('phone');
            $patients->email = $request->get('email');
            $patients->gender = $request->get('gender');
            $isSaved = $patients->save();
            if ($isSaved) {
            }
            return response()->json(['message' => $isSaved ? 'Patient created successfully' : 'Failed to create patient!'], $isSaved ? 201 : 400);
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
        $patients=Patient::findOrFail($id);
        $doctors=Doctor::where('active',true)->get();
        $cities=City::where('active',true)->get();
        return response()->view('cms.Patient.edit',['patients'=>$patients,'cities'=>$cities,'doctors'=>$doctors]);
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
            'doctor_id' => 'required|integer|exists:doctors,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'city_id' => 'required|integer|exists:cities,id',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$valodator->fails()){
        $patients =Patient::findOrFail($id);
        $patients->doctor_id = $request->get('doctor_id');
        $patients->first_name    = $request->get('first_name');
        $patients->last_name   = $request->get('last_name');
        $patients->city_id = $request->get('city_id');
        $patients->DoB    = $request->get('DoB');
        $patients->phone   = $request->get('phone');
        $patients->email = $request->get('email');
        $patients->gender = $request->get('gender');
        $isUpdated = $patients->save();
        return response()->json(['message' => $isUpdated ? 'Patient updated successfully' : 'Failed to updated patient!'], $isUpdated ? 201 : 400);
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
        $isDeleted = Patient::destroy($id);
        if($isDeleted){
            // return redirect()->back();
            return response()->json(['title'=>'Deleted!','message'=>'The patient is deleted!','icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!','message'=>'The patient is failed!','icon'=>'error'],400);
        }
    }
}
