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
        ->where('cookie_id' , '=' ,app('cart.cookie_id'))
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

   
}
