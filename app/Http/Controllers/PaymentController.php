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
        $batches = $user->studentBatches; // Fetch batches the student is enrolled in

        $sppTotal = $batches->sum('spp_nominal');

        $activeBill = (object) [
            'total' => $sppTotal,
            'due_date' => date('t M Y'), // End of current month
            'description' => 'Tagihan SPP',
            'invoice_number' => 'INV/' . date('Ymd') . '/' . str_pad($user->id, 4, '0', STR_PAD_LEFT)
        ];
        
        $isSppPaid = Payment::where('id_user', $user->id)
            ->where('payment_for', 'Biaya Pendidikan')
            ->whereMonth('payment_date', date('m'))
            ->whereYear('payment_date', date('Y'))
            ->where('status', 'lunas')
            ->exists();

        $isFullyPaid = $isSppPaid;

        $bankAccounts = \App\Models\BankAccount::all();

        return view('students.payment', compact('payments', 'batches', 'activeBill', 'isFullyPaid', 'bankAccounts'));
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

    public function studentInvoice()
    {
        $user = Auth::user();
        
        $batches = $user->studentBatches;
        $sppTotal = $batches->sum('spp_nominal');

        $activeBill = (object) [
            'total' => $sppTotal,
            'due_date' => date('t M Y'),
            'description' => 'Tagihan SPP',
            'invoice_number' => 'INV/' . date('Ymd') . '/' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'is_paid' => false
        ];

        $bankAccounts = \App\Models\BankAccount::all();

        return view('students.invoice', compact('user', 'activeBill', 'bankAccounts'));
    }

    public function historyInvoice($id)
    {
        $user = Auth::user();
        $payment = Payment::where('id_user', $user->id)->findOrFail($id);

        $activeBill = (object) [
            'total' => $payment->amount,
            'due_date' => \Carbon\Carbon::parse($payment->payment_date)->format('d M Y'),
            'description' => $payment->payment_for . ($payment->batch ? ' - ' . $payment->batch->nama : ''),
            'invoice_number' => 'INV/' . \Carbon\Carbon::parse($payment->created_at)->format('Ymd') . '/' . str_pad($payment->id, 4, '0', STR_PAD_LEFT),
            'is_paid' => true,
            'payment_date' => \Carbon\Carbon::parse($payment->payment_date)->format('d M Y'),
            'payment_method' => $payment->payment_method
        ];

        $bankAccounts = \App\Models\BankAccount::all();

        return view('students.invoice', compact('user', 'activeBill', 'bankAccounts'));
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
