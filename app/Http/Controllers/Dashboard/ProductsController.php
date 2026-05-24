<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
        // $this->middleware(['verified'])->except(['index' , 'show']);
     }


    public function index()
    {
        Gate::authorize('products.view');
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
        Gate::authorize('products.create');
        return view('dashboard.products.create', [
            'product'=> new Product(),
                        'availabillties' => Product::availabillties(), 
            'status_options' =>Product::statusOptions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('products.create');
        //
        $role = $this->role(null);
        
        $request->validate($role);
        

        // image

        $data = $request->except('image', 'images');

        $product=Product::create($data);

        if($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection('product-images');
            }
        }

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
        Gate::authorize('products.update');
        //
        $product=Product::findOrFail($id);
        return view('dashboard.products.edit',[
            'product' => $product,
            'availabillties' => Product::availabillties(), 
            'status_options' =>Product::statusOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    Gate::authorize('products.update');
    $product = Product::findOrFail($id);
    $role = $this->role($product->id); // قم بتمرير معرف المنتج هنا
    $request->validate($role);

    //IMAGE

    $data = $request->except('image', 'images', 'delete_media');

    $product->update($data);

    if($request->hasFile('images'))
    {
        foreach ($request->file('images') as $image) {
            $product->addMedia($image)->toMediaCollection('product-images');
        }
    }

    if($request->filled('delete_media'))
    {
        foreach ($request->input('delete_media') as $mediaId) {
            $media = $product->media()->find($mediaId);
            if ($media) {
                $media->delete();
            }
        }
    }

    return redirect()
    ->route('dashboard.products.index')
    ->with('success',"Product ($product->name) Updated");
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('products.delet');
        //
        $product=Product::withTrashed()->findOrFail($id);

        if($product->trashed())
        {
            $product->forceDelete();
            // if($product->image)
            // {
            //     Storage::disk('uploads')->delete($product->image);
            // }
        }
        else
        {
        $product->delete();
        }


        return redirect()
        ->route('dashboard.products.index')
        ->with('success',"Product ($product->name) Deleted");
    }

    public function trash()
    {
        $product= Product::onlyTrashed()->get();
        return view('dashboard.products.trash', [
            'products'=> $product
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

    public function role($productId)
{
    return [
        'name' => 'required|string|max:255',
        'category_id' => 'required|int|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'compare_price' => 'nullable|numeric|gt:price',
        'status' => 'in:active,draft,archived',
        'availabillty' => 'in:in-stock,out-of-stock,back-order',
        'quantity' => 'nullable|int|min:0',
        'sku' => 'nullable|string|unique:products,sku,' . $productId,
        'barcode' => 'nullable|string|unique:products,barcode',
        'images' => 'nullable|array',
        'images.*' => 'nullable|image|max:5120',
        'delete_media' => 'nullable|array',
        'delete_media.*' => 'nullable|integer',
    ];
}

//Illuminate\Http\UploadedFile

    public function upload(UploadedFile $file)
    {
        $path = $file->store('thumbnails', ['disk' => 'uploads']);

        if (!$path) {
            throw new \Exception('Failed to upload the file.');
        }

        return $path;
    }



}
