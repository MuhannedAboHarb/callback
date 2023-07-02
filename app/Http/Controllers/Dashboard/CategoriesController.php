<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    //
        //Read
        public function index()
    {
        $categories=Category::all(); /* Return a Collection that is mean object or array is work for we used the collect() method to create a Collection instance from the defined array */
        $title= 'Categories';
        return view('dashboard.categories.index', compact('title','categories'));
    }

        //Create
        public function create()
        {
            $categories = Category::orderBy('name')->get();
            return view('dashboard.categories.create',[
                'parents'=>$categories,
            ]);
        }

        // Create Strore
        public function store(Request $request)
        {
        $category=Category::create ([
            'name'=>$request->post('name'),
            'slug'=>Str::slug($request->post('name')),
            'parent_id'=>$request->post('parent_id'),
            'description'=>$request->post('description'),
        ]);
         // PRG: Post Redirect Get بحول من راوت الى راوت اخر وهذا مشهور في الويب
         return redirect()->route('dashboard.categories.index');
        }

        //Update two function
        public function edit ($id)
        {
            $category=Category::find($id);
            $parents=Category::where('id','<>',$id)
                ->orderBy('name')
                ->get();
            return view('dashboard.categories.edit',compact('category','parents'));
        }

        public function update () {}

        //Delete
        public function destroy () {}
}
