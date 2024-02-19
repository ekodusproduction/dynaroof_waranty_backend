<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request){
        if($request->isMethod('get')){
            return view('settings.change-password');
        }else if($request->isMethod('post')){

            $validator = Validator::make($request->all(),[
                'newPassword' => 'required|min:8|max:16',
                'confirmPassword' => 'required|same:newPassword'
            ]);

            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }else{
                User::where('id', Auth::user()->id)->update([
                    'password' => Hash::make($request->newPassword)
                ]);

                return back()->with('success', 'Your password has been successfully updated.');
            }
        }else{
            echo 'Oops! Something went wrong';
        }
        
    }
}
