<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(!Gate::check('roles.view')){
        //     abort(403,'You are not allowed to process this action');
        // }
        $roles = Role::withCount('users')->paginate();

        return view('dashboard.roles.index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(!Gate::check('roles.create')){
        //     abort(403,'You are not allowed to process this action');
        // }

        return view('dashboard.roles.create', [
            'role' => new Role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if(!Gate::check('roles.create')){
        //     abort(403,'You are not allowed to process this action');
        // }

        $request->validate([
            'name' => ['required'],
            'permissions' => ['required', 'array'],
        ]);
        $role = Role::create($request->all());

        return redirect()->route('dashboard.roles.index')
            ->with('success', __('Role ":name" created', [
                'name' => $role->name,
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
    public function edit(Role $role)
    {
        // if(!Gate::check('roles.update')){
        //     abort(403,'You are not allowed to process this action');
        // }

        return view('dashboard.roles.edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // if(!Gate::check('roles.update')){
        //     abort(403,'You are not allowed to process this action');
        // }

        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);
        $role->update($request->all());

        return redirect()->route('dashboard.roles.index')
            ->with('success', __('Role ":name" updated', [
                'name' => $role->name,
            ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // if(!Gate::check('roles.delet')){
        //     abort(403,'You are not allowed to process this action');
        // }

        $role->delete();

        return redirect()->route('dashboard.roles.index')
            ->with('success', __('Role ":name" deleted', [
                'name' => $role->name,
            ]));
    }
}
