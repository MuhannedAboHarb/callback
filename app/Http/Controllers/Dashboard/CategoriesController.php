<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
        //Read
        public function index()
    {
        $categories=[];
        //  $categories=Category::all();
    //   dd($categories);
        return view('dashboard.categories.index',[
            'title'=>'Categories List',
            'entries'=>$categories,
        ]);
    }

        //Create
        public function create()
        {
            return view('dashboard.categories.create');
        }

        // Create Strore
        public function store(Request $request)
        {
            return $request->all();
        }

        //Update two function
        public function edit () {}

        public function update () {}

        //Delete
        public function destroy () {}
}
