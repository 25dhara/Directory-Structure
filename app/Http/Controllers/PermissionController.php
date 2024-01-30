<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PermissionRequest;


class PermissionController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:permission-list|permission-insert|permission-update|permission-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:permission-insert', ['only' => ['insert', 'store']]);
    //     $this->middleware('permission:permission-update', ['only' => ['update', 'update']]);
    //     $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::all();
        return view('permissions.list', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'description' => $request->description,

        ]);
        return redirect()->route('permission.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('permission.edit', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(PermissionUpdateRequest $request, Permission $permission)
    // {

    //     $is_active = $request->has('is_active') ? 1 : 0;
    //     // $module = Module::find($request->module_id);
    //     // $name = strtolower($module->name) . "-" . $request->access;

    //     $haspermission = Permission::query()
    //         ->where('name', $name)
    //         ->where('module_id', $request->input('module_id'))
    //         ->where('id', '!=', $permission->id)
    //         ->exists();

    //     if ($haspermission) {
    //         return back()->withErrors([
    //             'access' => 'Access already exits.'
    //         ]);
    //     }

    //     $permission->update([
    //         'module_id' => $request->module_id,
    //         'name' => strtolower($module->name) . "-" . $request->access,
    //         'guard_name' => 'web',
    //         'description' => $request->description,
    //         'is_active' => $is_active,

    //     ]);
    //     return redirect()->route('permission.index')
    //         ->with('success', 'Permission updated successfully');
    // }
    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('permission.index')
            ->with('success', 'Permission updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();
        session()->flash('danger', 'Permission Deleted successfully.');
        return redirect()->route('permission.index');
    }
}
