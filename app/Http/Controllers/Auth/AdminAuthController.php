<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AdminAuthController extends Controller
{
    //
    public function showLogin(){
        return response()->view('cms.auth.login');
    }

    public function login(Request $request){

       $validator=Validator($request->all(),[
        'email' =>    'required|email|exists:admins,email',
        'password' => 'required|string|min:3',
        'remember_me'=>'boolean'
       ]);

       $credentials=['email'=>$request->get('email'),'password'=>$request->get('password')];

       if(!$validator->fails()){
        if(Auth::guard('admin')->attempt($credentials,$request->get('remember_me'))){
            return response()->json(['message'=>'Logged in Susseccfully'], 200);
        }else{
            return response()->json(['message'=>'Login is Faild'], 400);
        }
       }else{
           return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
       }

    }


    public function editPassword(){
        return response()->view('cms.auth.edit-password');
    }

    public function updatePassword(Request $request){

        $validator=Validator($request->all(),[
            'old_password' => 'required|string|password:admin',
            'new_password'=>'required|string|confirmed',
            'new_password_confirmation'=>'required|string',
        ]);

        if(!$validator->fails()){
            // $user=User::findOrFail($request->user('admin')->id);
            $user=$request->user('admin');
            $user->password=Hash::make($request->get("new_password"));
            $isSaved=$user->save();
            return response()->json(['message'=>'Password Changed is Successfully'], 200);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
        }
    }

    public function editProfile(Request $request){
        $cities=City::where('active',true)->get();
        return response()->view('cms.auth.edit-profile',['cities'=>$cities, 'admins' => $request->user('admin')]);
    }

    public function updateProfile(Request $request){
        $valodator=Validator($request->all(),[
            'city_id' => 'required|integer|exists:cities,id',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$valodator->fails()){
        $admins =$request->user('admin');
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

    public function logout(){
        auth('admin')->logout();
        // $request->auth('admin')->logout();
        return redirect()->route('auth.login.view');
    }
}
