<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserCreatedMail;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserUpdateRequest;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Requests\UserActivateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:user-list|user-insert|user-update|user-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:user-insert', ['only' => ['insert', 'store']]);
    //     $this->middleware('permission:user-update', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(UserRequest $request): RedirectResponse
    {
        $token = Str::random(100);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_by' => Auth::user()->id,
            'remember_token' => $token
        ]);

        // $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // $roles = Role::all();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {

        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('danger', 'User deleted successfully');
    }
}
