<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $users = User::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->latest()->paginate(10)->withQueryString();
        return view('user.index', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:teacher,student',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'status' => 'active',
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update_status(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->update(['status' => $request->status]);

        return redirect()->route('users.index')->with('success', 'Status pengguna berhasil diperbarui.');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'Berhasil di hapus!');
    }
}
