<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
{
    $search = $request->search ?? null;

    $users = User::when($search, function ($query, $search) {
        $query->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
    })->paginate();

    return view('user.index', compact('users'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $user = new User();
    return view('user.create', compact('user'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|max:50|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);
    $user->assignRole('petugas');

    return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(User $user)
{
    // Jika tidak ada halaman detail, bisa langsung abort
    abort(404);
}

public function edit(User $user)
{
    return view('user.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|max:50|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Enkripsi password hanya jika ada input password baru
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
