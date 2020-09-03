<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentController extends Controller
{
    public function index(){

        return view('payment');
    }

    public function payment(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required',
            'amount'=>'required|numeric',
         ]);
        $data = [
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'amount'=>$request->amount,
        ];

        return view('stripe',compact('data'));
    }

    public function stripePayment(Request $request){
        
        $amount= $request->amount;
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51H1CFLBWYiAmbMxSY0zWjaHeG2jrkRzmrGxBnchd60D0M6sqsm7Rd69ts5ceQV70k3aFb4MFN0Ctc5wA4SiNEJ6f00CRFXd3mZ');

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
        'amount' => $amount*100,
        'currency' => 'inr',
        'description' => 'Simple Payment',
        'source' => $token,
        'metadata' => ['order_id' => uniqid()],
        ]);

        $order =[
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'payment_id'=>$charge->payment_method,
            'paying_amount'=>$charge->amount/100,
            'blnc_transaction'=>$charge->balance_transaction,
            'stripe_order_id'=>$charge->metadata->order_id,
            'date'=>date('d-m-y'),
            'status_code'=>mt_rand(100000,999999),
            'status'=>0
        ];
        $orderId = Payment::insertGetId($order);
        
        $notification = array(
            'message' => 'Payment Processed!', 
            'alert-type' => 'success'
        );
        return Redirect()->to('/')->with($notification); 
        

        
    }
}
