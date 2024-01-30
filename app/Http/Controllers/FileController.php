<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $files = File::with('folder')->get();
        return view('files.list', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request here if needed

        $file = $request->file('file');
        $uuid = \Illuminate\Support\Str::uuid();


        $filename = $uuid . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filenameWithExtension = $filename . '.' . $extension;


        $file->move(public_path('storage/' . $uuid), $filenameWithExtension);


        File::create([
            'uuid' => $uuid,
            'folder_id' => $request->folder_id,
            'path' => 'storage/' . $uuid,
            'name' => $filenameWithExtension,
            'display_name' => $request->display_name,
            'extension' => $extension,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('files.index')
            ->with('success', 'File created successfully');
    }


    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $file = Files::findOrFail($id);
    //     $folders = Folder::all();

    //     return view('files.edit', compact('file', 'folders'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $file = Files::findOrFail($id);

    //     // Validate the request here if needed

    //     // Check if a new file is uploaded
    //     if ($request->hasFile('file')) {
    //         // A new file is uploaded, handle file update
    //         $newFile = $request->file('file');
    //         $uuid = $file->uuid;

    //         // Generate a unique filename with extension
    //         $filename = $uuid . '_' . $newFile->getClientOriginalName();
    //         $extension = $newFile->getClientOriginalExtension();
    //         $filenameWithExtension = $filename . '.' . $extension;

    //         // Move the file to the public storage directory
    //         $newFile->move(public_path('storage/' . $uuid), $filenameWithExtension);

    //         // Remove the old file
    //         Storage::delete($file->path . '/' . $file->name);

    //         // Update necessary information in the database
    //         $file->update([
    //             'folder_id' => $request->folder_id,
    //             'path' => 'storage/' . $uuid, // Store relative path from the public directory
    //             'name' => $filenameWithExtension,
    //             'display_name' => $request->display_name,
    //             'extension' => $extension,
    //             // Add other fields as needed
    //         ]);

    //         return redirect()->route('files.index')
    //             ->with('success', 'File updated successfully');
    //     }

    //     // If no new file is uploaded, update other information without changing the file
    //     $file->update([
    //         'folder_id' => $request->folder_id,
    //         'display_name' => $request->display_name,
    //         // Add other fields as needed
    //     ]);

    //     return redirect()->route('files.index')
    //         ->with('success', 'File information updated successfully');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     $file = Files::findOrFail($id);
    //     $file->delete();

    //     return redirect()->route('files.index')
    //         ->with('success', 'File deleted successfully');
    // }
}
