<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Folder;
use App\Models\Permission;
use App\Models\User_Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::id());

        $folders = $user->folders()->with('permissions')->get();
        $uniqueFolders = [];
        $filteredFolders = $folders->filter(function ($folder) use (&$uniqueFolders) {
            $folderName = $folder->name;
            if (!in_array($folderName, $uniqueFolders)) {
                $uniqueFolders[] = $folderName;
                return true;
            }
            return false;
        });
        return view('folders.list', compact('filteredFolders'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('folders.create', compact('permissions'));
        // return view('folders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Create the folder
        $folder = Folder::create([
            'name' => $request->name,
            'created_by' => Auth::id()
        ]);

        // Store permissions for the folder
        $permissions = $request->input('permissions', []);
        foreach ($permissions as $permission) {
            User_Folder::create([
                'folder_id' => $folder->id,
                'user_id' => Auth::id(),
                'permission_id' => $permission
            ]);
        }

        return redirect()->route('folders.index')
            ->with('success', 'Folder created successfully');
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
    public function edit(string $id)
    {
        $folder = Folder::find($id);
        return view('folders.edit', compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $folder = Folder::findOrFail($id);

        $folder->update([
            'name' => $request->name,
            // 'created_by' => $request->created_by, // Assuming 'created_by' is in the request
            // Add other fields as needed
        ]);

        return redirect()->route('folders.index')
            ->with('success', 'Folder updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        return redirect()->route('folders.index')
            ->with('success', 'Folder deleted successfully');
    }
}
