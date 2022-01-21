<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Paystack;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {

        $id = Auth::id();

        $student = Student::where('id',$id)->first();
        $student_id = Auth::id();

        $paymentDetails = Paystack::getPaymentData();

        $inv_id = $paymentDetails['data']['metadata']['invoiceId'];
        $status = $paymentDetails['data']['status'];
        $amount = $paymentDetails['data']['amount'];
        $number = $randnum = rand(1111111111,9999999999);
        $number = 'year'.$number;

        if($status == "success"){

            Payment::create(['student_id' => $student_id,'invoice_id'=>$inv_id,'amount'=>$amount,'status'=>1]);
            Student::where('id', $id)
                ->update(['register_no' => $number,'acceptance_status' => 1]);

            return view('student.studentFees');
        }

    }
}
