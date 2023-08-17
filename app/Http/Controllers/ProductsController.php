<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
}
