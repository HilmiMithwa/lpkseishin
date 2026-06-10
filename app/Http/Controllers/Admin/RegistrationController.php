<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentRegistration;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    // List semua pendaftar
    public function index(Request $request)
    {
        $query = StudentRegistration::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name or email/phone
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%")
                  ->orWhere('ktp_number', 'like', "%{$search}%");
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = ['pending', 'verified', 'accepted', 'rejected'];
        
        return view('admin.registrations.index', compact('registrations', 'statuses'));
    }

    // Detail pendaftar
    public function show($id)
    {
        $registration = StudentRegistration::findOrFail($id);
        $batches = Batch::whereIn('status', ['active', 'pendaftaran', 'Active'])->get();
        
        return view('admin.registrations.show', compact('registration', 'batches'));
    }

    // Verifikasi & Approve - buat akun siswa
    public function approve(Request $request, $id)
    {
        $validated = $request->validate([
            'id_batch' => 'required|exists:batch,id_batch',
            'notes' => 'nullable|string|max:500',
        ], [
            'id_batch.required' => 'Batch harus dipilih',
            'id_batch.exists' => 'Batch tidak valid',
        ]);

        $registration = StudentRegistration::findOrFail($id);

        $batch = Batch::withCount('students')->findOrFail($validated['id_batch']);
        if ($batch->students_count >= $batch->quota) {
            return back()->with('error', 'Gagal memverifikasi: Kuota batch sudah penuh.');
        }

        // Generate username dan password
        $baseUsername = Str::slug($registration->full_name);
        $username = $baseUsername;
        
        $counter = 1;
        while (User::where('email', $username . '@lpkseishin.com')->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $tempPassword = Str::random(12);

        // Buat user baru dengan role siswa (role_id = 2)
        $user = User::create([
            'name' => $registration->full_name,
            'email' => $username . '@lpkseishin.com',
            'password' => Hash::make($tempPassword),
            'nomor_telepon' => $registration->whatsapp_number,
            'tanggal_lahir' => $registration->birth_date,
            'role_id' => 2, // Siswa
            'status' => 'Active',
            'level' => $registration->japanese_level ?? 'N5',
        ]);

        // Tambahkan user ke batch
        DB::table('student_list_batch')->insert([
            'user_id' => $user->id,
            'id_batch' => $validated['id_batch'],
            'status' => 'Active',
            'register_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update registration status
        $registration->update([
            'status' => 'accepted',
            'current_step' => 4,
        ]);

        return back()->with([
            'success' => 'Pendaftar berhasil diverifikasi dan akun dibuat',
            'user_data' => [
                'username' => $username,
                'email' => $user->email,
                'password' => $tempPassword,
                'name' => $user->name,
            ]
        ]);
    }

    // Reject pendaftar
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi',
        ]);

        $registration = StudentRegistration::findOrFail($id);

        $registration->update([
            'status' => 'rejected',
        ]);

        // Simpan alasan penolakan sebagai note
        // Anda bisa tambah column di database atau gunakan activity log

        return back()->with('success', 'Pendaftar berhasil ditolak');
    }

    // Hapus pendaftar
    public function destroy($id)
    {
        $registration = StudentRegistration::findOrFail($id);
        $registration->delete();

        return back()->with('success', 'Data pendaftar berhasil dihapus');
    }

    // Export data pendaftar (optional)
    public function export()
    {
        // Implementasi export ke Excel nanti
    }
}
