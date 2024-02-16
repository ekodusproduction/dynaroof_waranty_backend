<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\SMSResponse;

class RegisteredCustomerController extends Controller
{
    use ApiResponse, SMSResponse;
    public function getRegisteredCustomer(){
        return view('customer.registered-customer');
    }

    public function registration(Request $request){
        $validator = Validator::make($request->all(),[
            'fullName' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'dealerName' => 'required',
            'materialType' => 'required',
            'dateOfPurchase' => 'required',
            'country' => 'required',
            'district' => 'required',
            'state'  => 'required',
            'colorOfSheets' => 'required',
            'numberOfSheets' => 'required|numeric',
            'serialNumber' => 'required',
            'thicknessOfSheets' => 'required|numeric',
            'invoice' => 'required | mimes:docx,pdf|max:1048',
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{
                $url = url('/');
                $main_image = $request->invoice;
                $file = null;
                if($request->hasFile('invoice')){
                    $new_name = date('d-m-Y-H-i-s') . '_' . $main_image->getClientOriginalName();
                    $main_image->move(public_path('customer/warranty/uploads/invoice/'), $new_name);
                    $file = $url . '/customer/warranty/uploads/invoice/' . $new_name;
                }
                $check_phone_exists = Customer::where('phone', $request->phone)->exists();
                $check_email_exists = Customer::where('email', $request->email)->exists();
                if($check_email_exists){
                    return $this->error('Oops! Email already exists', null, null, 400);
                }
                if(!$check_phone_exists){
                    $otp = rand(100000, 999999);
                    Customer::create([
                        'name' => $request->fullName,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'otp' => $otp,
                        'dealer_name' => $request->dealerName,
                        'material_type' => $request->materialType,
                        'date_of_purchase' => $request->dateOfPurchase,
                        'country' => $request->country,
                        'district' => $request->district,
                        'state'  => $request->state,
                        'color_of_sheets' => $request->colorOfSheets,
                        'number_of_sheets' => $request->numberOfSheets,
                        'serial_number' => $request->serialNumber,
                        'thickness_of_sheets' => $request->thicknessOfSheets,
                        'invoice' => $file,
                    ]);

                    
                    // $templateId = '1307167066897372955';
                    // $flowId = '6396aeb36fed3f4e8601e953';


                    // $sendOTPSMS =  $this->sendOTPSMS(null, $flowId, '91'.$request->phone, $otp );
                    $sendOTPSMS = true;
                    if($sendOTPSMS){
                        return $this->success('Great! Registration successfull', null, null, 200);
                    }
                }else{
                    return $this->error('Oops! Phone number already exists', null, null, 400);
                }

                

            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong'.$e->getMessage(), null, null, 500);
            }
        }
    }

    public function verifyOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{

              
                // Customer::where('phone', $request->phone)->where('otp', $request->otp)->update([
                //     'is_otp_verified' => 1
                // ]);
                // // $templateId = '1307167066897372955';
                // $flowId = '65c60c07d6fc05219d728073';

                // $this->sendNormalSMS(null, $flowId, '91'.$request->phone);
                return $this->success('OTP verified successfully', $request->otp, null, 200);
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong', null, null, 500);
            }
        }
    }

    public function resendOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{
                $otp = rand(100000, 999999);
                // $templateId = '1307167066897372955';
                $flowId = '6396aeb36fed3f4e8601e953';
                $sendOTPSMS =  $this->sendOTPSMS(null, $flowId, '91'.$request->phone, $otp );
                if($sendOTPSMS){
                    return $this->success('OTP sent successfully', $otp, null, 200);
                }
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong', null, null, 500);
            }
        }
    }
}
