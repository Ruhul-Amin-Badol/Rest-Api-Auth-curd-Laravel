<?php

namespace App\Http\Controllers\Api;

use Doctrine\Common\Lexer\Token;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class RegistarController extends BaseController
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'              => 'required|string|max: 255',
            'email'             => 'required|email',
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
        ] );

        if($validator->fails()){
            return $this->SendError('Validation error',$validator->errors());
        }

        $password = bcrypt($request->password);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $password,
        ]);

        $success['token'] =$user->createToken('RestApi')->plainTextToken;
        $success['name']  =$user->name;
        
        return $this->SentResponse( $success,'user registed successfully');
    }


    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:6',
           
        ] );

        if($validator->fails()){
            return $this->SendError('login validation error',$validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' =>$request-> password])){
            $user=Auth::user();
            $success['Token']=$user->CreateToken("RestApi")->plainTextToken;
            $success['name']=$user->name;

            return $this->SentResponse('User Login Successfully',$success);
        }else{
            return $this->SendError('Unauthorize',['error'=>'Unauthorize']);
        }
    }

    public function logout(){
        Auth()->user()->tokens()->delete();
        return $this->SentResponse([],'User logout successfully');
    }
}
