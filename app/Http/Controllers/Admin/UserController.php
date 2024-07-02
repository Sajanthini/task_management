<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin-only');
    }

    public function index()
    {
        $users = User::with('role')->orderBy('id', 'desc')->paginate(15);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            // Return validation errors as a response with a 400 status code
            return response()->json(['errors' => $validator->errors()], 400);
        }

         // Create a new user
         $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role_id'=>$request->input('role_id'),
            'password' => Hash::make($request->input('password')),
        ]);
        // return response()->json([
        //     'user' => $user, 
        //     'message'=> 'User Registered Sucessfully'], 200);
        return to_route('admin.users.index')->with('message', 'User Created !');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate(['role_id' => 'required|exists:roles,id']);
        $user->role_id = $validated['role_id'];
        $user->update();

        return to_route('admin.users.index')->with('message', 'Role to user Updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.users.index')->with('message', 'User Deleted !');
    }
}
