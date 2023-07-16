<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products=Product::all();
        return view('dashboard.products.index', [
            'products'=> $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.products.create', [
            'product'=> new Product()      //  هين ببعث مودل فاضي عشان اعتمد ملف مشترك بين الإدت وال كريت
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $role = $this->role();
        $request->validate($role);
        $product=Product::create($request->all());
        return redirect()
        ->route('dashboard.products.index')
        ->with('success',"Product ($product->name) Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product=Product::findOrFail($id);
        return view('dashboard.products.show',[
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product=Product::findOrFail($id);
        return view('dashboard.products.edit',[
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $product=Product::findOrFail($id);
        $role = $this->role();
        $request->validate($role);
        $product->update($request->all());
        return redirect()
        ->route('dashboard.products.index')
        ->with('success',"Product ($product->name) Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()
        ->route('dashboard.products.index')
        ->with('success',"Product ($product->name) Deleted");
    }

    public function trash()
    {
        $product= Product::onlyTrashed()->get();
        return view('dashboard.products.trash', [
            'product'=> $product
        ]);
        
    }


    public function restore(Request $request,string $id)
    {
        //
        $product=Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()
        ->route('dashboard.products.index')
        ->with('success',"Product ($product->name) Restored");
    }

    public function role()
    {
        return [
            'name' => 'required|string max:255',
            'category_id' => 'required|int|exists:categories , id',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'status' => 'in: active , draft , archived ',
            'availabillty' => 'in: in-stock, out-of-stock ,back-order',
            'quantity' => 'nullable|int|min:0',
            'sku' => 'nullable|string|uinque:products,sku',
            'barcode' => 'nullable|string|uinque:products,barcode',
            'image'=> 'nullable|image',

        ];
    }
}
