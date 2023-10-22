<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        if($validator->fails()){
            return $this->sendError('Validate Error',$validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MuhammedEssa')->accessToken;
        $success['name'] = $user->name;
        $response = ['success'=>true , 'data'=>$success,'message'=>'User registered Successfully!'];
        return response($response, 200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email'=> $request->email,'password' => $request->password])){
            //$user = Auth::user();
            $user = User::where('email', $request->email)->first();
            $success['token'] = $user->createToken('MuhammedEssa')->accessToken;
            $success['name'] = $user->name;
            $response = ['success'=>true , 'data'=>$success,'message'=>'User login Successfully!'];
            return response($response, 200);
            // return $this->sendResponse($success,'User Login Successfully!');
        }
        else{
            $response = ['success'=>false ,'message'=>'Unauthorised!'];
            return response($response, 200);
            // return $this->sendError('Unauthorised',['error','Unauthorised']);
        }



    }
}
