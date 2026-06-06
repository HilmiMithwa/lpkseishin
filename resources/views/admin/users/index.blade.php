@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - LPK Seishin')

@section('content')
<div class="p-6 lg:p-8 space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[32px] font-bold text-slate-800 leading-tight">Manajemen Pengguna</h1>
            <p class="text-[15px] font-semibold text-slate-500 mt-1">Kelola data siswa, guru, dan admin sistem.</p>
        </div>
        <div>
            <button x-data="" x-on:click.prevent="$dispatch('open-add-user-modal')" class="bg-[#d62828] text-white hover:bg-red-800 font-bold py-2.5 px-5 rounded-xl shadow-[0_2px_10px_-4px_rgba(214,40,40,0.5)] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <x-card class="overflow-hidden" padding="none">
        
        <!-- Toolbar (Tabs & Search) -->
        <div class="p-5 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            
            <!-- Tabs -->
            <div class="flex bg-slate-50 p-1 rounded-xl w-full sm:w-auto overflow-x-auto custom-scrollbar">
                <a href="?role=siswa" 
                   class="flex-1 sm:flex-none text-center px-5 py-2 rounded-lg font-bold text-sm transition-all whitespace-nowrap {{ request('role', 'siswa') == 'siswa' ? 'bg-white text-[#d62828] shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                   Siswa
                </a>
                <a href="?role=guru" 
                   class="flex-1 sm:flex-none text-center px-5 py-2 rounded-lg font-bold text-sm transition-all whitespace-nowrap {{ request('role') == 'guru' ? 'bg-white text-[#d62828] shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                   Guru
                </a>
                <a href="?role=admin" 
                   class="flex-1 sm:flex-none text-center px-5 py-2 rounded-lg font-bold text-sm transition-all whitespace-nowrap {{ request('role') == 'admin' ? 'bg-white text-[#d62828] shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                   Admin
                </a>
            </div>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.users') }}" class="relative w-full sm:w-64">
                <input type="hidden" name="role" value="{{ request('role', 'siswa') }}">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition-all sm:text-sm font-medium text-slate-800" placeholder="Cari pengguna...">
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl">Pengguna</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Bergabung Pada</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f3f4f6&color=d62828&bold=true" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $user->nomor_telepon ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-edit-user-modal', { user: { id: '{{ $user->id }}', role: '{{ $roleName }}', name: '{{ addslashes($user->name) }}', email: '{{ $user->email }}', phone: '{{ $user->nomor_telepon }}', school: '' } })" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-on:click="$dispatch('open-delete-user-modal', { id: '{{ $user->id }}' })" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic text-sm">
                            Tidak ada data pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between text-sm gap-3 font-semibold">
            <span class="font-medium text-slate-500">
                Menampilkan 
                <span class="font-bold text-slate-800">{{ $users->firstItem() ?? 0 }}</span> 
                hingga 
                <span class="font-bold text-slate-800">{{ $users->lastItem() ?? 0 }}</span> 
                dari 
                <span class="font-bold text-slate-800">{{ $users->total() }}</span> 
                pengguna
            </span>
            <div class="users-pagination">
                {{ $users->links() }}
            </div>
        </div>

    </x-card>

    @push('modals')
    <!-- Modal Tambah/Edit Pengguna -->
    <x-modal name="add-user-modal" focusable maxWidth="2xl">
        <form method="POST" :action="isEdit ? '{{ url('admin/users') }}/' + userId : '{{ route('admin.users.store') }}'" 
              x-data="{ role: '{{ old('role', $roleName) }}', isEdit: {{ old('userId') ? 'true' : 'false' }}, name: '{{ old('name') }}', email: '{{ old('email') }}', phone: '{{ old('phone') }}', school: '', userId: '{{ old('userId') }}' }" 
              @open-add-user-modal.window="isEdit = false; role = '{{ $roleName }}'; name = ''; email = ''; phone = ''; school = ''; userId = ''; $dispatch('open-modal', 'add-user-modal')"
              @open-edit-user-modal.window="isEdit = true; role = $event.detail.user.role; name = $event.detail.user.name; email = $event.detail.user.email; phone = $event.detail.user.phone; school = $event.detail.user.school; userId = $event.detail.user.id; $dispatch('open-modal', 'add-user-modal')">
            @csrf
            
            <!-- Hidden inputs -->
            <input type="hidden" name="userId" x-bind:value="userId">
            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>
            
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-3">
                    <h2 class="text-[22px] font-bold text-slate-800" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'">
                    </h2>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-500 hover:bg-red-200 rounded-full transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Form Body -->
            <div class="space-y-6">
                <!-- Role Selection -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="block text-[13px] font-bold text-slate-500 mb-2">Peran / Role:</label>
                        <select x-model="role" id="role" name="role" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru (Sensei)</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="name" class="block text-[13px] font-bold text-slate-500 mb-2">Nama Lengkap:</label>
                        <input x-model="name" id="name" type="text" name="name" required placeholder="e.g., Budi Santoso" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-[13px] font-bold text-slate-500 mb-2">Alamat Email:</label>
                        <input x-model="email" id="email" type="email" name="email" required placeholder="e.g., email@contoh.com" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-[13px] font-bold text-slate-500 mb-2">Nomor WhatsApp:</label>
                        <input x-model="phone" id="phone" type="text" name="phone" required placeholder="e.g., 08123456789" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- School (Conditional) -->
                <div x-show="role === 'siswa'" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="school" class="block text-[13px] font-bold text-slate-500 mb-2">Asal Sekolah / Universitas:</label>
                        <input x-model="school" id="school" type="text" name="school" placeholder="e.g., SMA Negeri 1" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                    </div>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-[13px] font-bold text-slate-500 mb-2">Kata Sandi:</label>
                        <input id="password" type="password" name="password" x-bind:required="!isEdit" :placeholder="isEdit ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter'" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-[13px] font-bold text-slate-500 mb-2">Konfirmasi Kata Sandi:</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" x-bind:required="!isEdit" :placeholder="isEdit ? 'Kosongkan jika tidak diubah' : 'Ulangi kata sandi'" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="mt-10 flex items-center gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="w-[140px] py-3.5 rounded-2xl border-2 border-[#d62828] text-[#d62828] font-bold text-sm hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/20">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#d62828] hover:bg-red-700 text-white font-bold text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/50 shadow-md hover:shadow-lg" x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna'">
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Konfirmasi Hapus -->
    <x-modal name="delete-user-modal" focusable maxWidth="md">
        <form method="POST" :action="'{{ url('admin/users') }}/' + deleteUserId" x-data="{ deleteUserId: '' }" @open-delete-user-modal.window="deleteUserId = $event.detail.id; $dispatch('open-modal', 'delete-user-modal')">
            @csrf
            @method('DELETE')
            <div class="p-6">
                <div class="flex items-center justify-center w-14 h-14 mx-auto bg-red-100 rounded-full mb-5">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-center text-slate-800 mb-2">Hapus Pengguna?</h3>
                <p class="text-sm text-center text-slate-500 mb-8">Apakah Anda yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan lagi.</p>
                
                <div class="flex items-center gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-3.5 text-sm font-bold text-slate-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3.5 text-sm font-bold text-white bg-[#d62828] hover:bg-red-700 rounded-2xl shadow-md hover:shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/50">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

    @if ($errors->any())
        <div x-data x-init="$dispatch('open-modal', 'add-user-modal')"></div>
    @endif

    @if (session('success'))
        <div x-data x-init="$dispatch('show-toast', { message: '{{ session('success') }}' })"></div>
    @endif
    @endpush
</div>
@endsection
