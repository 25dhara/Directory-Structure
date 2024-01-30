<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleUpdateRequest;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\Datatables;

class RoleController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:role-list|role-insert|role-update|role-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:role-insert', ['only' => ['insert', 'store']]);
    //     $this->middleware('permission:role-update', ['only' => ['update', 'update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $roles = Role::all();
        return view('roles.list', compact('roles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name
        ]);

        if ($request->permissions) {
            $selectedPermissions = $request->input('permissions', []);
            // dd($selectedPermissions);
            $role->syncPermissions($selectedPermissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
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
        return view('roles.edit', compact('role'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $is_active = $request->is_active == "on" ? 1 : 0;
        $role->update(['name' => $request->name, 'description' => $request->description, 'is_active' => $is_active]);
        $selectedPermissions = $request->input('permissions', []);
        $role->syncPermissions($selectedPermissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        $is_active = $request->is_active == "on" ? 1 : 0;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        // $role->permissions()->detach();
        session()->flash('danger', 'Role Deleted successfully.');
        return redirect()->route('roles.index');
    }
    public function roleStatus(Request $request)
    {
        $role = Role::find($request->id);
        $role->is_active = $request->is_active;
        $role->save();
        if ($request->is_active == 1) {
            return response()->json(['success' => 'Role Activated']);
        } else {
            return response()->json(['success' => 'Role Deactivated']);
        }
    }
    public function trashedRole(Request $request)
    {
        if ($request->ajax()) {
            $trashedRoles = Role::onlyTrashed();
            return Datatables::eloquent($trashedRoles)->make(true);
        }
        return view('trash.role_list');
    }
    public function restore($id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        $role->restore();
        session()->flash('success', 'Role Restored successfully.');
        return redirect()->route('roles.index');
    }
    public function delete($id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        $role->forceDelete();
        session()->flash('danger', 'Role Deleted successfully.');
        return view('trash.role_list');
    }
}
