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
    public function create()
    {
        $permissions = Permission::all();
        return view('folders.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $folder = Folder::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

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
    public function edit($id)
    {
        $folder = Folder::findOrFail($id);
        $permissions = Permission::all();
        return view('folders.edit', compact('folder', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $folder = Folder::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:folders,name,' . $folder->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $folder->name = $request->name;
        $folder->save();

        $user_id = Auth::id();
        $permissions = $request->input('permissions', []);

        $folder->users()->detach($user_id);

        foreach ($permissions as $permission) {
            $folder->users()->attach($user_id, ['permission_id' => $permission]);
        }
        return redirect()->route('folders.index')->with('success', 'Folder updated successfully');
    }
    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        $hasFiles = $folder->files()->exists();
        if ($hasFiles) {
            return back()->with('danger', 'Cannot delete the folder because it has associated files.');
        }

        $folder->delete();
        return redirect()->route('folders.index')->with('danger', 'Folder deleted successfully');
    }
}
