<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(Auth::id());

        $folders = $user->folders()->with('permissions')->get();
        $uniqueFolderNames = $folders->pluck('name')->unique();

        $files = File::with('folder')->whereHas('folder', function ($query) use ($uniqueFolderNames) {
            $query->whereIn('name', $uniqueFolderNames);
        })->get();

        return view('files.list', compact('files'));
    }
    public function create()
    {
        $user = User::find(Auth::id());
        $all_folder = $user->folders()->get();
        $uniqueFolders = [];
        $folders = $all_folder->filter(function ($folder) use (&$uniqueFolders) {
            $folderName = $folder->name;
            if (!in_array($folderName, $uniqueFolders)) {
                $uniqueFolders[] = $folderName;
                return true;
            }
            return false;
        });
        return view('files.create', compact('folders'));
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $file->move(public_path('storage/'), $request->name . '.' . $extension);

        File::create([
            'uuid' => Str::uuid(),
            'folder_id' => $request->folder_id,
            'path' => 'storage/' . $request->display_name,
            'name' => $request->name,
            'display_name' => $request->display_name,
            'extension' => $extension,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('files.index')
            ->with('success', 'File created successfully');
    }

    public function edit($id)
    {
        $file = File::findOrFail($id);

        $user = User::find(Auth::id());
        $allFolders = $user->folders()->get();
        $uniqueFolders = [];

        $folders = $allFolders->filter(function ($folder) use (&$uniqueFolders) {
            $folderName = $folder->name;
            if (!in_array($folderName, $uniqueFolders)) {
                $uniqueFolders[] = $folderName;
                return true;
            }
            return false;
        });
        return view('files.edit', compact('file', 'folders'));
    }

    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'file' => 'nullable|file|max:10240',
        ]);

        $file->name = $request->name;
        $file->display_name = $request->display_name;

        if ($request->hasFile('file')) {
            if (file_exists(public_path($file->path))) {
                unlink(public_path($file->path));
            }
            $newFile = $request->file('file');
            $extension = $newFile->getClientOriginalExtension();
            $newFileName = $request->name . '.' . $extension;
            $newFile->move(public_path('storage/'), $newFileName);
            $file->path = 'storage/' . $newFileName;
            $file->extension = $extension;
        }
        $file->save();
        return redirect()->route('files.index')->with('success', 'File updated successfully');
    }


    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->route('files.index')
            ->with('danger', 'File deleted successfully');
    }
}
