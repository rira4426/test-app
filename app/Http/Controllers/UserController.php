<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SetPinRequest;
use App\Http\Requests\RegisterMobileRequest;
use App\Http\Requests\RegisterOnDeviceRequest;

use App\Http\Resources\RegisterMobileResource;
use App\Http\Resources\RegisterVerifyResource;

use App\Models\User;
use App\Models\Otp;

use App\Events\UserSignedUp;

class UserController extends Controller
{
    public function RegisterMobile(RegisterMobileRequest $request){
        $user = User::where('mobile', $request->mobile)->first();

        if(!$user){
            $user = new User();
            $user->mobile = $request->mobile;
            $user->exist = false;
        }else{
            $user['exist'] =  true;
        }
       
        $user->code = 555555;

        UserSignedUp::dispatch($user);
        Otp::create(['mobile'=>$request->mobile,'code'=>$user->code]);
        return new RegisterMobileResource($user);
    }
     
    public function RegisterVerify(RegisterVerifyRequest $request){
        $user = User::where('mobile', $request->mobile)->first();
        if($user){
            $isVerified = Otp::where('mobile',$request->verification_code)->first();
            
            if($isVerified){
                $user->verified = true;
                $user->save();
            }
            
            return new RegisterVerifyResource($user);
        }

        $signUp = new SignUp();
        $signUp->mobile = $request->mobile;
        $signUp->register_token = sha1( $request->mobile . now());
        $signUp->save();
        return new RegisterVerifyResource($user);
    }

    public function RegisterOnDevice(RegisterOnDeviceRequest $request){
        $signUpExists = SignUp::where('register_token', $request->registration_token)->first();

        if($signUpExists){
            User::create(['name'=>$request->name, 'email'=>$request->email,'mobile'=>signUpExists->mobile]);
            $signUpExists->delete();
            return new RegisterVerifyResource($user);
        }
    }

    public function SetPin(SetPinRequest $request){
        dd($request->pin);
    }
}
