<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
                            // نفس الاسم الي داخل صفحة ال الويب لازم
    public function index(Category $category = null )
    { 
        if(!$category)
        {
            $category = new Category();
            $products = Product::with('category')->latest()->paginate(15);
        } 
        else
        {
            $products = $category->products()->with('category')->latest()->paginate();
        }
        return view('store.products.index', [
            'category'=> $category,
            'products'=>$products
        ]);
    }

    public function show(Category $category , Product $product)
    {
        return view('store.products.show',compact('category','product'));
    }

    // public function show($category_slug ,  $product_slug)
    // {
    //     $category = Category::whereSlug($category_slug)->firstOrFail();
    //     $product = $category->products()-> whereSlug($product_slug)->firstOrFail();
    //     return view('store.products.show',compact('category','product'));
    // }

    public function review(Request $request, Product $product)
    {
        $request->validate([
            'rating' => ['required', 'int', 'min:1', 'max:5'],
            'review' => ['nullable', 'string'],
        ]);
        $review = $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->post('rating'),
            'review' => $request->post('review'),
        ]);

        $result = $product->reviews()
            ->selectRaw('AVG(rating) as avg_rating')
            ->selectRaw('COUNT(*) as total_reviews')
            ->first();

        $product->forceFill([
            'rating' => $result->avg_rating,
            'total_reviews' => $result->total_reviews,
        ])->save();

        return redirect()->to($product->url)
            ->with('success', __('Product reviewd'));
    }

}
