<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class authController extends Controller
{
    public function loginUser(Request $request)
    {
        $validation =  Validator::make($request->all(),[
            'email'  => 'required|string|email|exists:users,email',
            'password'  => 'required|string',
        ]);

        // if email does not exits 
        if($validation->fails()){
            return response(['status'=> 400, 'message'=>$validation->errors()->first()]);
        }else{
            $credentials = array('email'=>$request->email, 'password'=>$request->password);
            
            // if credential is not false
            if(Auth::attempt($credentials,false)){
                if(Auth::User()->hasRole('admin')){
                    return response(['status'=> 200, 'message'=>'Admin User']);
                }else{
                    return response(['status'=> 200, 'message'=>'Non User']);
                }
            }else{
                return response(['status'=> 400, 'message'=>'Wrong credentials']);
                
            }
        }
    }
}
