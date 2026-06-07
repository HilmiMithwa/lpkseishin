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

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $studentBatch = \Illuminate\Support\Facades\DB::table('student_list_batch')
            ->where('user_id', $user->id)
            ->first();
        $batches = \App\Models\Batch::all();
        $guruBatches = $user->batches()->pluck('batch.id_batch')->toArray();

        return view('admin.users.edit', compact('user', 'studentBatch', 'batches', 'guruBatches'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->input('form_type') === 'akademik') {
            $request->validate([
                'batch_id' => 'required|exists:batch,id_batch',
                'register_date' => 'required|date',
                'status_keaktifan' => 'required|in:Active,Inactive,Completed',
                'level' => 'required|string|max:50',
            ]);

            $user->update([
                'level' => $request->level,
                'status' => $request->status_keaktifan
            ]);

            \Illuminate\Support\Facades\DB::table('student_list_batch')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'id_batch' => $request->batch_id,
                    'register_date' => $request->register_date,
                    'status' => $request->status_keaktifan,
                    'updated_at' => now(),
                ]
            );

            return redirect()->route('admin.users', ['role' => 'siswa'])
                ->with('success', 'Data akademik berhasil disimpan!');
        }

        if ($request->input('form_type') === 'guru_batch') {
            $request->validate([
                'batches' => 'nullable|array',
                'batches.*' => 'exists:batch,id_batch',
            ]);

            $selectedBatches = $request->input('batches', []);
            $user->batches()->sync($selectedBatches);

            return redirect()->route('admin.users', ['role' => 'guru'])
                ->with('success', 'Batch berhasil ditugaskan!');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:admin,siswa,guru'],
            'status' => ['nullable', 'string', 'in:Active,Inactive,Completed'],
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

        if ($request->has('status')) {
            $user->status = $validated['status'];
        }

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
