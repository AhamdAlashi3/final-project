<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{
    use FileUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $doctors=Doctor::withCount('patients')->with(['cities'])->paginate(10);
        return response()->view('cms.Doctor.index',['doctors'=>$doctors]);
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
        return response()->view('cms.Doctor.create',['cities'=>$cities]);
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
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'specialization' => 'required|string|min:3|max:30',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
            'active' => 'in:on'
        ]);
        if (!$validator->fails()) {
            $doctors = new Doctor();
            if ($request->hasFile('image')) {
                $this->uploadFile($request->file('image'), 'images/doctors/', 'public', 'abc_doctors_' . time());
                $doctors->image = Storage::url($this->filePath);
            }

            $doctors->city_id = $request->get('city_id');
            $doctors->first_name   = $request->get('first_name');
            $doctors->last_name   = $request->get('last_name');
            $doctors->specialization = $request->get('specialization');
            $doctors->DoB = $request->get('DoB');
            $doctors->phone   = $request->get('phone');
            $doctors->email = $request->get('email');
            $doctors->gender = $request->get('gender');
            $doctors->active = $request->has('active') ? true : false;
            $isSaved = $doctors->save();
            if ($isSaved) {
                 return response()->json(['message' => $isSaved ? 'doctor created successfully' : 'Failed to create doctor!'], $isSaved ? 201 : 400);
            }
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
        $doctors=Doctor::findOrFail($id);
        $cities = City::where('active', true)->get();
        return response()->view('cms.Doctor.edit',['doctors'=>$doctors, 'cities'=>$cities]);
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
            'specialization' => 'required|string|min:3|max:30',
            'DoB' => 'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
            'active' => 'required|boolean'
        ]);
        if(!$valodator->fails()){
        $doctors =Doctor::findOrFail($id);
        $doctors->city_id = $request->get('city_id');
        $doctors->first_name    = $request->get('first_name');
        $doctors->last_name   = $request->get('last_name');
        $doctors->specialization    = $request->get('specialization');
        $doctors->DoB    = $request->get('DoB');
        $doctors->phone   = $request->get('phone');
        $doctors->email = $request->get('email');
        $doctors->gender = $request->get('gender');
        $doctors->active = $request->get('active');
        $isUpdated = $doctors->save();
        return response()->json(['message' => $isUpdated ? 'Doctor updated successfully' : 'Failed to updated doctor!'], $isUpdated ? 201 : 400);
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
        $isDeleted = Doctor::destroy($id);
        if($isDeleted){
            // return redirect()->back();
            return response()->json(['title'=>'Deleted!','message'=>'The doctor is deleted!','icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!','message'=>'The doctor is failed!','icon'=>'error'],400);
        }
    }
}
