<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\{Stripe,Charge,Customer};
class PurchaseController extends Controller
{
    public function create()
    {
        return view('payment.index');
    }
    public function store()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken')
        ]);
        Charge::create([
            'customer' => $customer->id,
            'amount' => 2500,
            'currency' => 'usd'
        ]);
    }
}