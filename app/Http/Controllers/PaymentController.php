<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // ====== STUDENT METHODS ====== //

    public function studentIndex()
    {
        $user = Auth::user();
        
        // Fetch student's payment history
        $payments = Payment::where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Fetch available batches for the dropdown
        $batches = Batch::where('status', 'Active')->get();

        // Calculate total unpaid or pending bills if we had a billing system,
        // for now we just show a static bill or simple calculation
        $activeBill = (object) [
            'total' => 'Rp 1.500.000',
            'due_date' => date('t M Y'), // End of current month
            'description' => 'Tagihan SPP / Pendaftaran'
        ];
        
        $isFullyPaid = false; // Add real logic here if needed

        return view('students.payment', compact('payments', 'batches', 'activeBill', 'isFullyPaid'));
    }

    public function studentStore(Request $request)
    {
        $request->validate([
            'id_batch' => 'nullable|exists:batch,id_batch',
            'payment_for' => 'required|string|max:255',
            'payment_method' => 'required|string|max:100',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'description' => 'nullable|string',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        $user = Auth::user();

        $path = $request->file('proof_image')->store('payments', 's3');

        Payment::create([
            'id_user' => $user->id,
            'id_batch' => $request->id_batch,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'payment_for' => $request->payment_for,
            'description' => $request->description,
            'proof_path' => $path,
            'status' => 'menunggu',
        ]);

        return redirect()->route('students.payment')->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi admin.');
    }

    // ====== ADMIN METHODS ====== //

    public function adminIndex(Request $request)
    {
        $query = Payment::with(['user', 'batch'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('batch')) {
            $query->where('id_batch', $request->batch);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $payments = $query->paginate(10);
        $batches = Batch::all();

        return view('admin.payments.index', compact('payments', 'batches'));
    }

    public function adminVerify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:lunas,ditolak',
            'admin_note' => 'nullable|string',
        ]);

        $payment = Payment::findOrFail($id);
        
        $payment->status = $request->status;
        if ($request->filled('admin_note')) {
            $payment->admin_note = $request->admin_note;
        }

        $payment->save();

        $message = $request->status === 'lunas' ? 'Pembayaran berhasil diverifikasi (Lunas).' : 'Pembayaran telah ditolak.';

        return redirect()->route('admin.payments')->with('success', $message);
    }
}
