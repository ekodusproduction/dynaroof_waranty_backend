<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Warranty;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\SMSResponse;

class RegisteredCustomerController extends Controller
{
    use ApiResponse, SMSResponse;
    public function getRegisteredCustomer(){
        try{
            $get_customers = Customer::orderBy('created_at', 'DESC')->get();
            return view('customer.registered-customer')->with(['customer' => $get_customers]);
        }catch(\Exception $e){
            echo 'Oops! Something went wrong.';
        }
        
    }

    public function getCustomerDetails(Request $request){
        $customer_id = decrypt($request->customer_id);
        try{
            $get_details = Customer::where('id', $customer_id)->first();
            return $this->success('Great! Details fetched successfully', $get_details, null, 200);
        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong', null, null, 500);
        }
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
            'thicknessOfSheets' => 'required',
            'invoice' => 'required|mimetypes:image/jpeg,image/jpg,image/png,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5048',
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{

                $customer_details = Customer::where('phone', $request->phone)->first();

                if($customer_details != null){
                    if($customer_details->country == 'bhutan'){
                        return $this->error('Oops! Customer details already exists. Please enter new phone number and email.', null, null, 400);
                    }else{
                        if($customer_details->is_otp_verified == 0){

                            $otp = rand(100000, 999999);
    
                            $customer_details->update([
                                'otp' => $otp
                            ]);
                            
                            // $flowId = '6396aeb36fed3f4e8601e953';
                            $flowId = '66769e0bd6fc0510b9627642';
                            $sendOTPSMS =  $this->sendOTPSMS(null, $flowId, '91'.$request->phone, $otp );
                            // $sendOTPSMS = true;
                            if($sendOTPSMS){
                                return $this->success('Great! OTP sent successfull', null, null, 200);
                            }
                        }else{
                            if($customer_details->email == $request->email){
                                return $this->error('Oops! Email already exists', null, null, 400);
                            }else if($customer_details->phone == $request->phone){
                                return $this->error('Oops! Phone already exists', null, null, 400);
                            }else{
                                return $this->error('Oops! Something went wrong', null, null, 500);
                            }
                        }
                    }
                    
                }else{

                    $main_image = $request->invoice;
                    $file = null;
                    if($request->hasFile('invoice')){
                        $new_name = date('d-m-Y-H-i-s') . '_' . $main_image->getClientOriginalName();
                        $main_image->move(public_path('customer/warranty/uploads/invoice/'), $new_name);
                        $file = 'customer/warranty/uploads/invoice/' . $new_name;
                    }

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
                    
                    if($request->country == 'bhutan'){
                        return $this->success('Thank you for applying. Your warranty card will be issued after the details are being reviewed successfully.', $request->country, null, 200);
                    }else{
                        // $flowId = '6396aeb36fed3f4e8601e953';
                        $flowId = '66769e0bd6fc0510b9627642';

                        $sendOTPSMS =  $this->sendOTPSMS(null, $flowId, '91'.$request->phone, $otp );
                        // $sendOTPSMS = true;
                        if($sendOTPSMS){
                            return $this->success('Great! OTP sent successfull', null, null, 200);
                        }
                    }
                    // $templateId = '1307167066897372955';
                    
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

                $get_customer = Customer::where('phone', $request->phone)->first();
                if($get_customer->otp == $request->otp){
                    Customer::where('phone', $request->phone)->update([
                        'is_otp_verified' => 1
                    ]);

                    // $templateId = '1307167066897372955';
                    $flowId = '65c60c07d6fc05219d728073';

                    $this->sendNormalSMS(null, $flowId, '91'.$request->phone);

                    return $this->success('OTP verified successfully', null, null, 200);
                }else{
                    return $this->error('Invalid OTP', null, null, 400);
                }
                
                
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong'.$e->getMessage(), null, null, 500);
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
                Customer::where('phone', $request->phone)->update([
                    'otp' => $otp
                ]);
                // $templateId = '1307167066897372955';
                // $flowId = '6396aeb36fed3f4e8601e953';
                $flowId = '66769e0bd6fc0510b9627642';
                $sendOTPSMS =  $this->sendOTPSMS(null, $flowId, '91'.$request->phone, $otp );
                if($sendOTPSMS){
                    return $this->success('OTP sent successfully', null, null, 200);
                }
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong'.$e->getMessage(), null, null, 500);
            }
        }
    }

    public function downloadInvoiceCount(Request $request){
        $customer_id = $request->customer_id;
        try{
            Customer::where('id', $customer_id)->update([
                'is_invoice_downloaded' => 1
            ]);
            return $this->success('Great! Count updated successfully', null, null, 200);
        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong'.$e->getMessage(), null, null, 500);
        }
    }

    public function deleteCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            $customer_id = decrypt($request->customer_id);
            try{
                Customer::where('id', $customer_id)->delete();
                Warranty::where('customer_id', $customer_id)->delete();
                return $this->success('Great! Customer deleted successfully', null, null, 200);
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong'.$e->getMessage(), null, null, 500);
            }
        }
    }

    public function editCustomer($id){
        $customer_id = decrypt($id);
        try{
            $customer_details = Customer::where('id', $customer_id)->first();
            return view('customer.edit-customer')->with(['customer' => $customer_details]);
        }catch(\Exception $e){
            echo 'Oops! Something went wrong';
        }
    }

    public function saveEditCustomerDetails(Request $request){
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required',
            'serial_number' => 'required|min:6|max:6',
            'phone' => 'required|digits:10|numeric'
        ]);

        if($validator->fails()){
            return $this->error('Oops! '.$validator->errors()->first(), null, null, 400);
        }else{
            try{
                Customer::where('id', $request->customer_id)->update([
                    'serial_number' => $request->serial_number,
                    'phone' => $request->phone
                ]);
                return $this->success('Great! Details updated successfully', null, null, 200);
            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong', null, null, 500);
            }
        }
    }
}
