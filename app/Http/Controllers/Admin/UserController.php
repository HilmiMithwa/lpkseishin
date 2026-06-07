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

        if ($request->ajax()) {
            $query = User::where('role_id', $roleId);
            
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('pengguna', function ($row) {
                    $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=f3f4f6&color=d62828&bold=true';
                    return '<div class="flex items-center gap-3">
                                <img src="' . $avatar . '" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">' . htmlspecialchars($row->name) . '</p>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5">' . htmlspecialchars($row->email) . '</p>
                                </div>
                            </div>';
                })
                ->addColumn('kontak', function ($row) {
                    return '<p class="text-sm font-semibold text-slate-700">' . htmlspecialchars($row->nomor_telepon ?? '-') . '</p>';
                })
                ->addColumn('status_badge', function ($row) {
                    $status = $row->status ?? 'Active';
                    $bgClass = $status === 'Active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($status === 'Inactive' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-blue-50 text-blue-600 border-blue-100');
                    $dotClass = $status === 'Active' ? 'bg-emerald-500' : ($status === 'Inactive' ? 'bg-rose-500' : 'bg-blue-500');
                    $label = $status === 'Active' ? 'Aktif' : ($status === 'Inactive' ? 'Tidak Aktif' : 'Selesai');
                    
                    return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold border ' . $bgClass . '">
                                <span class="w-1.5 h-1.5 rounded-full ' . $dotClass . '"></span> ' . $label . '
                            </span>';
                })
                ->addColumn('bergabung', function ($row) {
                    return '<p class="text-sm font-semibold text-slate-700">' . ($row->created_at ? $row->created_at->translatedFormat('d M Y') : '-') . '</p>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.users.edit', $row->id);
                    return '<div class="flex items-center justify-center gap-2">
                                <a href="' . $editUrl . '" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button onclick="window.dispatchEvent(new CustomEvent(\'open-modal\', { detail: \'delete-user-modal\' }))" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>';
                })
                ->rawColumns(['pengguna', 'kontak', 'status_badge', 'bergabung', 'action'])
                ->make(true);
        }

        $users = collect(); // Placeholder for initial load

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

        $payments = collect();
        if ($user->role_id == 2) {
            $payments = \App\Models\Payment::with('batch')
                ->where('id_user', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.users.edit', compact('user', 'studentBatch', 'batches', 'guruBatches', 'payments'));
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
