@extends('layouts.admin')

@section('title', 'Manajemen Rekening Bank - LPK Seishin')

@section('content')
<div class="p-6 lg:p-8 space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[32px] font-bold text-slate-800 leading-tight">Manajemen Rekening</h1>
            <p class="text-[15px] font-semibold text-slate-500 mt-1">Kelola rekening bank untuk pembayaran siswa.</p>
        </div>
        <div>
            <button x-data="" x-on:click.prevent="$dispatch('open-add-bank-modal')" class="bg-[#d62828] text-white hover:bg-red-800 font-bold py-2.5 px-5 rounded-xl shadow-[0_2px_10px_-4px_rgba(214,40,40,0.5)] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Rekening
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <x-card class="overflow-hidden" padding="none">
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl">Nama Bank</th>
                        <th class="px-6 py-4">Nomor Rekening</th>
                        <th class="px-6 py-4">Atas Nama</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($accounts as $account)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-800">{{ $account->bank_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $account->account_number }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $account->account_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-edit-bank-modal', { account: { id: '{{ $account->id }}', bank_name: '{{ addslashes($account->bank_name) }}', account_number: '{{ addslashes($account->account_number) }}', account_name: '{{ addslashes($account->account_name) }}' } })" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-on:click="$dispatch('open-delete-bank-modal', { id: '{{ $account->id }}' })" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500 italic text-sm">
                            Belum ada rekening bank.
                        </td>
                    </tr>
                    @endforelse
            </table>
        </div>
    </x-card>

    @push('modals')
    <!-- Modal Tambah/Edit Bank -->
    <x-modal name="add-bank-modal" focusable maxWidth="md">
        <form method="POST" :action="isEdit ? '{{ url('admin/bank-accounts') }}/' + accountId : '{{ route('admin.bank_accounts.store') }}'" 
              x-data="{ isEdit: {{ old('accountId') ? 'true' : 'false' }}, bank_name: '{{ old('bank_name') }}', account_number: '{{ old('account_number') }}', account_name: '{{ old('account_name') }}', accountId: '{{ old('accountId') }}' }" 
              @open-add-bank-modal.window="isEdit = false; bank_name = ''; account_number = ''; account_name = ''; accountId = ''; $dispatch('open-modal', 'add-bank-modal')"
              @open-edit-bank-modal.window="isEdit = true; bank_name = $event.detail.account.bank_name; account_number = $event.detail.account.account_number; account_name = $event.detail.account.account_name; accountId = $event.detail.account.id; $dispatch('open-modal', 'add-bank-modal')">
            @csrf
            
            <input type="hidden" name="accountId" x-bind:value="accountId">
            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>
            
            <div class="flex justify-between items-start mb-6 px-6 pt-6">
                <h2 class="text-xl font-bold text-slate-800" x-text="isEdit ? 'Edit Rekening' : 'Tambah Rekening'"></h2>
                <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="space-y-4 px-6 pb-6">
                <div>
                    <label for="bank_name" class="block text-sm font-bold text-slate-500 mb-1">Nama Bank:</label>
                    <input x-model="bank_name" id="bank_name" type="text" name="bank_name" required placeholder="e.g., Bank BCA" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-[#d62828] focus:border-[#d62828] p-3">
                    @error('bank_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="account_number" class="block text-sm font-bold text-slate-500 mb-1">Nomor Rekening:</label>
                    <input x-model="account_number" id="account_number" type="text" name="account_number" required placeholder="e.g., 8821 000 123" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-[#d62828] focus:border-[#d62828] p-3">
                    @error('account_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="account_name" class="block text-sm font-bold text-slate-500 mb-1">Atas Nama:</label>
                    <input x-model="account_name" id="account_name" type="text" name="account_name" required placeholder="e.g., LPK Seishin Indonesia" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-[#d62828] focus:border-[#d62828] p-3">
                    @error('account_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="px-6 pb-6 flex gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-3 rounded-xl border border-gray-200 text-slate-600 font-bold text-sm hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-[#d62828] hover:bg-red-700 text-white font-bold text-sm shadow-md" x-text="isEdit ? 'Simpan' : 'Tambah'"></button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Konfirmasi Hapus -->
    <x-modal name="delete-bank-modal" focusable maxWidth="sm">
        <form method="POST" :action="'{{ url('admin/bank-accounts') }}/' + deleteAccountId" x-data="{ deleteAccountId: '' }" @open-delete-bank-modal.window="deleteAccountId = $event.detail.id; $dispatch('open-modal', 'delete-bank-modal')">
            @csrf
            @method('DELETE')
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-500 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Rekening?</h3>
                <p class="text-sm text-slate-500 mb-6">Rekening ini tidak akan muncul lagi di halaman pembayaran siswa.</p>
                <div class="flex gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-[#d62828] rounded-xl text-sm font-bold text-white hover:bg-red-700 shadow-sm">Hapus</button>
                </div>
            </div>
        </form>
    </x-modal>

    @if ($errors->any())
        <div x-data x-init="$dispatch('open-modal', 'add-bank-modal')"></div>
    @endif

    @if (session('success'))
        <div x-data x-init="$dispatch('show-toast', { message: '{{ session('success') }}' })"></div>
    @endif
    @endpush
</div>
@endsection
