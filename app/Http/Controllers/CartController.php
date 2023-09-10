<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str; //////////////////////

class CartController extends Controller
{
    // List of cart products (itme)
    public function index()
    {

    }

    // Add Product to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required','integer','exists:products,id'] ,
            'quantity' => ['integer','min:1']
        ]);

        $cart = Cart::where([
            'cookie_id'=> $this->getCookieId(),
            'product_id'=> $request->post('product_id'),
        ])->first();

        if(! $cart)
        {
            Cart::create([
                'id'=> Str::uuid() , //genrate random id 
                'cookie_id'=> $this->getCookieId(),
                'user_id'=> Auth::id(), // بترجع نل في حال لايوجد اي دي
                'product_id'=> $request->post('product_id'),
                'quantity'=> $request->post('quantity',1), // الواحد قيمة افتراضية
            ]);
        } else {
            $cart->increment('quantity', $request->post('quantity',1) );
        }

        return redirect()->back()->with('success' , 'Product added to Cart');
    }


    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if( ! $cookie_id)
        {
            $cookie_id = Str::uuid();               // بتخزن البيانات لمدة شهر
            Cookie::queue('cart_id', $cookie_id , 24 *60 *30); //لما ترسل الرسبونسف  عند لليوزر تروح تكتب عند اليوزر على مستوى المتصفح
        }
        return $cookie_id ; 
    }

}
