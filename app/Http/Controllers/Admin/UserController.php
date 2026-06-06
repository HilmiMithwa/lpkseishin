<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roleName = $request->query('role', 'siswa');
        $roleId = match($roleName) {
            'admin' => 1,
            'guru' => 3,
            default => 2, // siswa
        };

        $search = $request->query('search');
        $users = User::where('role_id', $roleId)
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nomor_telepon', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'roleName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:admin,siswa,guru'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $roleId = match($validated['role']) {
            'admin' => 1,
            'guru' => 3,
            default => 2, // siswa
        };

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nomor_telepon' => $validated['phone'],
            'role_id' => $roleId,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users', ['role' => $validated['role']])
            ->with('success', 'Data pengguna berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:admin,siswa,guru'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $roleId = match($validated['role']) {
            'admin' => 1,
            'guru' => 3,
            default => 2, // siswa
        };

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->nomor_telepon = $validated['phone'];
        $user->role_id = $roleId;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users', ['role' => $validated['role']])
            ->with('success', 'Perubahan berhasil disimpan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $roleId = $user->role_id;
        $roleName = match($roleId) {
            1 => 'admin',
            3 => 'guru',
            default => 'siswa',
        };

        $user->delete();

        return redirect()->route('admin.users', ['role' => $roleName])
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
