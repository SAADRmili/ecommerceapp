<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

            if (Cart::count()<=0)
            {
                return redirect()->route('products.index');
            }


        Stripe::setApiKey('sk_test_51HX7nULHbUnW8P4V0PDdPSkBt9sING47lxFQ9YjjuD0rhQDKBuE08hCok7qRTgi6D7cSoUwwMM3ADqNJW6wMqBjC00fCAElUiD'
    );
    $intent = PaymentIntent::create([
        'amount' => round( Cart::total()),
        'currency' => 'eur',
        // 'metaData'=>[
        //     'userId'=>15
        // ]
      ]);

      $clientSecret = Arr::get($intent,'client_secret');

        return view('checkout.index',[
            'clientSecret'=>$clientSecret
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Cart::destroy();
        $data = $request->json()->all();
        return $data['paymentIntent'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
