<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WarrantyCardController extends Controller
{
    use ApiResponse;
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
            $data = [
                'name' => $get_customers->name,
                'address' => $get_customers->district.', '.$get_customers->state.', '.$get_customers->country,
                'phone' => $get_customers->phone,
                'serial_no' => $get_customers->serial_number,
                'material_type' => $get_customers->material_type,
                'purchase_date' => $get_customers->date_of_purchase,
                'warranty_issue_date' => Carbon::now(),
                'warranty_valid_till' => $warranty_valid_till
            ];

            $pdf = PDF::loadView('warranty.load-warranty', $data)->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('warranty_card.pdf');
        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong'.$e->getMessage().' Line number ==>'.$e->getLine(), null, null, 500);
        }
    }
}
