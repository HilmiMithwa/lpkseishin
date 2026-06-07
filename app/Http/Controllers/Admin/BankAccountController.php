<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::all();
        return view('admin.bank_accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        BankAccount::create($validated);

        return redirect()->route('admin.bank_accounts')
            ->with('success', 'Rekening bank berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $account = BankAccount::findOrFail($id);

        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $account->update($validated);

        return redirect()->route('admin.bank_accounts')
            ->with('success', 'Rekening bank berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $account = BankAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.bank_accounts')
            ->with('success', 'Rekening bank berhasil dihapus!');
    }
}
