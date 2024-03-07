<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Warranty;
use App\Traits\ApiResponse;
use App\Traits\SMSResponse;
use App\Traits\TermsAndConditions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;

class WarrantyCardController extends Controller
{
    use ApiResponse, SMSResponse, TermsAndConditions ;
    public function generateWarrantyCard(Request $request){
        try{
            $get_customers = Customer::where('is_warranty_issued', 0)->get();
            return view('warranty.warranty')->with(['get_customers' => $get_customers]);
        }catch(\Exception $e){
            echo 'Oops! Something went wrong';
        }
    }

    public function loadWarrantyCard(Request $request){
        try{
            $get_customers = Customer::where('id', $request->customer_id)->first();
            $warranty_valid_till = null;
            if($get_customers->material_type == 'SuperPro(20 Years)'){
                $warranty_valid_till = Carbon::now()->addYears(20);
            }else{
                $warranty_valid_till = Carbon::now()->addYears(10);
            }
            $address = null;

            if($get_customers->state == 'null'){
                $address = $get_customers->district.', '.$get_customers->country;
            }else{
                $address =  $get_customers->district.', '.$get_customers->state .', '.$get_customers->country;
            }

            $data = [
                'name' => $get_customers->name,
                'address' => $address,
                'phone' => $get_customers->phone,
                'serial_no' => $get_customers->serial_number,
                'material_type' => $get_customers->material_type,
                'purchase_date' => $get_customers->date_of_purchase,
                'warranty_issue_date' => Carbon::now(),
                'warranty_valid_till' => $warranty_valid_till,
                'terms_and_conditions' => $this->termsAndConditions()
            ];

            

            $pdf = PDF::loadView('warranty.load-warranty', $data)->setOptions(['defaultFont' => 'sans-serif']);
            $pdfContents = $pdf->output();

            // Generate a unique filename for the PDF
            $pdfFileName = uniqid() . '_warranty_card.pdf';
            
            // Save the PDF to the public folder
            file_put_contents(public_path($pdfFileName), $pdfContents);

            Warranty::create([
                'customer_id' => $get_customers->id,
                'card_link' => $pdfFileName,
                'warranty_issue_date' => Carbon::now(),
                'warranty_valid_till' => $warranty_valid_till
            ]);

            Customer::where('id', $get_customers->id)->update([
                'is_warranty_issued' => 1
            ]);

            return back()->with('success', 'Great! Waranty card generated successfully.');
            
        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong'.$e->getMessage().' Line number ==>'.$e->getLine(), null, null, 500);
        }
    }

    public function viewCards(){
        try{
            $get_warranty = Warranty::with('customers')->orderBy('created_at', 'DESC')->get();
            return view('warranty.view-cards')->with(['get_warranty' => $get_warranty]);
        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong', null, null, 500);
        }
    }

    public function sendWarrantyCardLink(Request $request){
        try{
            $customer_id = $request->customer_id;
            $phone = $request->phone;
            $material = $request->material;
            $link = $request->link;

            $flowId = '65dec7e6d6fc057a2d7627e2';
            $sendOTPSMS =  $this->sendWarrantyLinkSMS($flowId, '91'.$phone, $material, $link );
            // $sendOTPSMS = true;
            if($sendOTPSMS){
                Warranty::where('customer_id', $customer_id)->update([
                    'is_download_link_sent' => 1
                ]);
                return $this->success('Great! Warranty card download link sent successfull', null, null, 200);
            }

        }catch(\Exception $e){
            return $this->error("Oops! Something went wrong".$e->getMessage(), null, null, 500);
        }
    }
}
