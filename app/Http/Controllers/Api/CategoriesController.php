<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('auth:sanctum')->except('index' , 'show');
     }

    public function index()
    {
        //
        $categories = Category::paginate(2);

        return $categories;
    } 

    /**
     * 
     * 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('sanctum')->user(); // or id()
        if (! $user->tokenCan('categories.create')) {
            abort(403, 'You don not access to this resource!');
        }
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        ]);
        $category = Category::create($request->all());

        return response($category, 201 , [
            'content-type' => 'application/json',
            'x-message' => __('Category Created')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::with('products')->findOrFail($id);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) // Category $category
    {
        //
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'parent_id' => ['sometimes', 'required', 'int', 'exists:categories,id'],
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return $category;
    }

    /*


public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'parent_id' => ['sometimes', 'required', 'int', 'exists:categories,id'],
        ]);
        $category->update($request->all());
        return $category;
    }


    */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete($id);
        return [
            'message' => __('Category Delete'),
        ];
    }
    /*

    public function destroy(Category $categor)
{
    $category->delete();
    return ['message' => __('Category Deleted')];
}

    */
}
