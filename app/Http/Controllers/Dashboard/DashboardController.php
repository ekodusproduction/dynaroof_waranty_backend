<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Warranty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $customer = Customer::where('is_otp_verified', 1)->count();
        $warranty = Warranty::count();
        return view('dashboard.dashboard')->with(['customer_count' => $customer, 'warranty' => $warranty]);
    }
}
