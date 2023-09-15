<?php

namespace App\Repositories\Cart ;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DatabaseRepository implements CartRepository
{   
     protected $items;

     protected $cookie_id ;

     public function __construct($cookie_id)
     {
        $this->cookie_id = $cookie_id ;
     }

    // بترجع جميع العناصر داخل السلة
    public function all ()
    {
        $this->items = Cart::with('product')
        ->where('cookie_id' , '=' ,$this->cookie_id)    //تبديل
        ->orWhere('user_id' , '=' , Auth::id())
        ->get();

        return $this->items ;
    }

    public function add ($item , $qty = 1)
    {

        $cook_id = $this->cookie_id;   //تبديل

        $cart = Cart::where([
            'cookie_id'=> $cook_id,
            'product_id'=> $item,
        ])->first();

        if(! $cart)
        {
            Cart::create([
                'id'=> Str::uuid() , //genrate random id 
                'cookie_id'=> $cook_id,
                'user_id'=> Auth::id(), // بترجع نل في حال لايوجد اي دي
                'product_id'=> $item,
                'quantity'=> $qty, // الواحد قيمة افتراضية
            ]);
        } else {
            $cart->increment('quantity', $qty );
        }         
    }
    
    public function remove ($id)
    {
        Cart::where([
            'id' => $id ,
            'cookie_id' => $this->cookie_id,   //تبديل
        ])->delete();
    }

    // حذف كل عناصر السلة
    public function empty ()
    {
        Cart::where([
            'cookie_id' => $this->cookie_id,   //تبديل
        ])->delete(); 
    }
    //مجموع السلة
    public function total()
    {
        return $this->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    public function setUserId($id)
    {
        $user =  Auth::user();  // or this   $user = auth()->user();     

        Cart::where('cookie_id' , '=' ,$this->cookie_id)
            ->update([
                'user_id' => $id
            ]);
    }

}