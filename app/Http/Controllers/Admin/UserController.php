<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,manager',
        ]);

        // 'role' is not mass assignable — set it explicitly here (admin-only action)
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password']; // hashed by the model cast
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', "{$user->name} added as {$user->role}.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,manager',
            'password' => 'nullable|string|min:8',
        ]);

        // Never let an admin strip their own admin role, or demote the last admin.
        if ($data['role'] !== 'admin' && $user->role === 'admin') {
            if ($user->id === $request->user()->id) {
                return back()->with('error', "You can't remove your own admin role.");
            }
            if (User::where('role', 'admin')->count() <= 1) {
                return back()->with('error', 'At least one admin must remain.');
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated!');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', "You can't delete your own account.");
        }
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'At least one admin must remain.');
        }
        $user->delete();
        return back()->with('success', 'User removed.');
    }
}
