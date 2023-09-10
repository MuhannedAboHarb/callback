<?php

namespace App\View\Components;

use App\Models\Cart;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class CartMenu extends Component
{
    public $cart ;

    public $total = 0 ; 
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
       $this->cart = Cart::with('product')
        ->where('cookie_id' , '=' , $this->getCookieId())
        ->orWhere('user_id' , '=' , Auth::id())
        ->get();

        $this->total = $this->cart->sum(function($item){ // use collection (count and sum)
            return $item->quantity * $item->product->price ;
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
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
