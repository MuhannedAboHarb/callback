<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class CategoriesController extends Controller
{
    //
        //Read
        public function index()
    {
        $categories=Category::leftJoin('categories as parents','parents.id' , '=' , 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ]) //بتنفذ جملة الاستعلام
        // ->whereNull('categories.parent_id')
        ->orderBy('id')
        ->get();
        $title= 'Categories';
        return view('dashboard.categories.index', compact('title','categories'));
    }

        //Create
        public function create()
        {
            $categories = Category::orderBy('name')->get();
              return view('dashboard.categories.create',[
                'parents'=>$categories,
                'category'=> new Category()
            ]);
        }

        // Create Strore
        public function store(Request $request)
        {
            $rules=$this->role();
            $request->validate($rules);
            $category=Category::create ([
                'name'=>$request->post('name'),
                'slug'=>Str::slug($request->post('name')),
                'parent_id'=>$request->post('parent_id'),
                'description'=>$request->post('description'),
        ]);
         return redirect()->route('dashboard.categories.index');
        }

        //Update two function
        public function edit ($id)
        {
            $category=Category::find($id);
            if($category==null)
            {
                abort(404);
            }
            $parents=Category::where('id','<>',$id)
                ->orderBy('name')
                ->get();
            return view('dashboard.categories.edit',compact('category','parents'));
        }

        public function update (Request $request,$id)
        {
            $rules=$this->role($id);
            $request->validate($rules);


            $category = Category::find($id);
            $category->name=$request->post('name');
            $category->parent_id = $request->post('parent_id');
            $category->description = $request->post('description');
            $category->save();
            return redirect(route('dashboard.categories.index'));

        }

        //Delete
        public function destroy ($id)
        {
            Category::destroy($id);
            return redirect(route('dashboard.categories.index'));
        }

        protected function role()
        {
            return [
                'name'=>[
                    'required',
                    'string',
                    'max:14',
                    // Rule::unique('categories','name')->ignore('id'),
                    
                ] ,
                'parent_id'=>'nullable|int|exists:categories,id',
                'description'=>'nullable|string|min:5|max:100',
                'image'=>'nullable|mimes:png,jpg|max:100',
            ];
        }
}
