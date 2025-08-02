<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(!Gate::check('users.view')){
        //     abort(403,'You are not access this page');
        // }
        $users =User::with('roles')->paginate();
        return view('dashboard.users.index',[
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(!Gate::check('users.create')){
        //     abort(403,'You are not access this page');
        // }
        return view('dashboard.users.create',[
            'user'=>new User,
            'user_roles'=> []

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if(!Gate::check('users.create')){
        //     abort(403,'You are not access this page');
        // }
        $request->validate([
            'name'=> 'required',
            'roles'=> 'required|array',
        ]);
        $user = User::create($request->all());
        $user->roles()->attach($request->post('roles'));
        
        return redirect()->route('dashboard.users.index')
            ->with('success', __('User ":name" created',[
                'name'=> $user->name
            ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // if(!Gate::check('users.update')){
        //     abort(403,'You are not access this page');
        // }
        $user_roles=$user->roles()->pluck('id')->toArray();
        return view('dashboard.users.edit',[
            'user'=> $user,
            'user_roles'=> $user_roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // if(!Gate::check('users.update')){
        //     abort(403,'You are not access this page');
        // }
        $request->validate([
            'name'=> 'required',
            'roles'=> 'required|array',
        ]);
        $user->update($request->all());

        $user->roles()->sync($request->post('roles'));

        return redirect()->route('dashboard.users.index')
            ->with('success', __('User ":name" updated',[
                'name'=> $user->name
            ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // if(!Gate::check('users.delet')){
        //     abort(403,'You are not access this page');
        // }
        $user->delete();
        return redirect()->route('dashboard.users.index')
            ->with('success', __('User ":name" deleted',[
                'name'=> $user->name
            ]));
    }
}
