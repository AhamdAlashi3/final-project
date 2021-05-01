<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    //
    public function showLogin(){
        return response()->view('cms.auth-user.login');
    }

    public function login(Request $request){

       $validator=Validator($request->all(),[
        'email' =>    'required|email|exists:users,email',
        'password' => 'required|string|min:3',
        'remember_me'=>'boolean'
       ]);

       $credentials=['email'=>$request->get('email'),'password'=>$request->get('password')];

       if(!$validator->fails()){
        if(Auth::guard('user')->attempt($credentials,$request->get('remember_me'))){
            return response()->json(['message'=>'Logged in Susseccfully'], 200);
        }else{
            return response()->json(['message'=>'Login is Faild'], 400);
        }
       }else{
           return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
       }

    }

    public function editPassword(){
        return response()->view('cms.auth-user.edit-password');
    }

    public function updatePassword(Request $request){

        $validator=Validator($request->all(),[
            'old_password' => 'required|string|password:user',
            'new_password'=>'required|string|confirmed',
            'new_password_confirmation'=>'required|string',
        ]);

        if(!$validator->fails()){
            // $user=User::findOrFail($request->user('admin')->id);
            $user=$request->user('user');
            $user->password=Hash::make($request->get("new_password"));
            $isSaved=$user->save();
            return response()->json(['message'=>'Password Changed is Successfully'], 200);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()], 400);
        }
    }

    public function editProfile(Request $request){
        $cities=City::where('active',true)->get();
        return response()->view('cms.auth-user.edit-profile',['cities'=>$cities, 'user' => $request->user('user')]);
    }

    public function updateProfile(Request $request){
        $valodator=Validator($request->all(),[
            'city' => 'required|string|min:3|max:30',
            'first_name' =>'required|string|min:3|max:30',
            'last_name'=>'required|string|min:3|max:30',
            'phone' => 'required|string|min:3|max:30',
            'email' => 'required|string|min:3|max:30',
            'gender' => 'required|in:M,F|string',
        ]);
        if(!$valodator->fails()){
        $user =$request->user('user');
        $user->city = $request->get('city');
        $user->first_name    = $request->get('first_name');
        $user->last_name   = $request->get('last_name');
        $user->phone   = $request->get('phone');
        $user->email = $request->get('email');
        $user->gender = $request->get('gender');
        $user->password = Hash::make('user2020');
        $isUpdated = $user->save();
        return response()->json(['message' => $isUpdated ? 'User updated successfully' : 'Failed to updated user!'], $isUpdated ? 201 : 400);
        }else{
        return response()->json(['message'=>$valodator->getMessageBag()->first()], 400);
        }
    }

    public function logout(){
        auth('user')->logout();
        // $request->auth('admin')->logout();
        return redirect()->route('auth-user.login.view');
    }
}
