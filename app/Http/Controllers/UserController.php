<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->paginate();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        // Ambil daftar role dari database (Spatie)
        $roles = Role::pluck('name', 'name')->all();
        return view('user.create', compact('user', 'roles'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|max:50|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|in:admin,petugas',
    ]);

    // Pisahkan data role dari data user
    $role = $validated['role'];
    unset($validated['role']);

    // Enkripsi password
    $validated['password'] = bcrypt($validated['password']);

    // Simpan user ke database
    $user = User::create($validated);

    // Assign role ke user baru
    $user->assignRole($role);

    return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|max:50|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role'     => 'required|in:admin,petugas',
    ]);

    $role = $validated['role'];
    unset($validated['role']);

    if ($request->filled('password')) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);
    $user->syncRoles([$role]);

    return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
