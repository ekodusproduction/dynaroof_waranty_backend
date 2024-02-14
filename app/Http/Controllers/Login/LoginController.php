<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return $this->success('Great! Login successfull.', '/dashboard', null, 200);
                }else{
                    return $this->error('Oops! Invalid credentials', null, null, 400);
                }
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong.', null, null, 500);
            }
        }
    }
}
