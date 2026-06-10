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
        
        <!-- Toolbar (Filters & Search) -->
        <div class="p-5 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            
            <!-- Filter Batch -->
            <div class="w-full sm:w-auto">
                @if(request('role', 'siswa') == 'siswa')
                <select id="batch-filter" class="w-full bg-white border border-gray-200 text-slate-700 text-sm font-bold rounded-xl focus:ring-[#d62828] focus:border-[#d62828] p-2.5 transition-shadow">
                    <option value="">Semua Batch</option>
                    @foreach(\App\Models\Batch::all() as $batch)
                        <option value="{{ $batch->id_batch }}">{{ $batch->nama }}</option>
                    @endforeach
                </select>
                @else
                <div class="hidden sm:block"></div>
                @endif
            </div>

            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="dt-search" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition-all sm:text-sm font-medium text-slate-800" placeholder="Cari pengguna...">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="users-table" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl w-12 text-center">No</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th id="th-batch" class="px-6 py-4" style="display: none;">Batch</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Bergabung Pada</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                </tbody>
            </table>
        </div>
        
        <!-- Custom Pagination Footer (Tailwind) -->
        <div class="px-6 py-4 border-t border-gray-100 bg-white flex flex-col md:flex-row items-center justify-between gap-4 text-sm font-medium text-gray-600">
            <div id="custom-dt-info" class="w-full md:w-auto text-center md:text-left">
                Menampilkan 0 - 0 dari 0 data.
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-6 w-full md:w-auto">
                <div class="flex items-center gap-2">
                    <span>Rows per page:</span>
                    <select id="custom-dt-length" class="py-1.5 pl-3 pr-8 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 focus:outline-none focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828]/20 cursor-pointer">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                
                <!-- Dynamic Pagination Container -->
                <div id="custom-dt-pagination" class="flex items-center gap-2">
                    <!-- Rendered by JS -->
                </div>
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

    @push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('admin.users') }}",
                data: function (d) {
                    d.role = "{{ request('role', 'siswa') }}";
                    d.batch_id = $('#batch-filter').val() || '';
                    d.search.value = $('#dt-search').val() || '';
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4 text-center font-bold text-slate-700'); } },
                { data: 'pengguna', name: 'pengguna', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } },
                { data: 'kontak', name: 'kontak', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } },
                { data: 'batch', name: 'batch', orderable: false, searchable: false, visible: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } },
                { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } },
                { data: 'bergabung', name: 'bergabung', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } },
                { data: 'action', name: 'action', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-6 py-4'); } }
            ],
            dom: '<"w-full overflow-x-auto"t>',
            drawCallback: function(settings) {
                var api = this.api();
                var info = api.page.info();
                
                $('#custom-dt-info').html(
                    'Menampilkan ' + (info.recordsDisplay > 0 ? info.start + 1 : 0) + ' - ' + info.end + ' dari ' + info.recordsDisplay + ' data.'
                );
                
                // Custom Pagination rendering
                let paginationHtml = '';
                let currentPage = info.page;
                let totalPages = info.pages;

                if (totalPages > 0) {
                    // Prev Button
                    let prevDisabled = currentPage === 0;
                    let prevClass = prevDisabled 
                        ? 'bg-red-50 text-red-300 cursor-not-allowed opacity-70' 
                        : 'bg-red-50 text-[#d62828] hover:bg-red-100 cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] transition ${prevClass}" data-action="previous" ${prevDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    </button>`;

                    // Pages
                    let startPage = Math.max(0, currentPage - 1);
                    let endPage = Math.min(totalPages - 1, currentPage + 1);

                    if (currentPage === 0) endPage = Math.min(totalPages - 1, 2);
                    if (currentPage === totalPages - 1) startPage = Math.max(0, totalPages - 3);

                    for (let i = startPage; i <= endPage; i++) {
                        let activeClass = i === currentPage 
                            ? 'bg-[#d62828] text-white shadow-md shadow-red-500/20 border-transparent' 
                            : 'bg-white text-gray-600 border border-transparent hover:bg-gray-50';
                            
                        paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] text-sm font-semibold transition ${activeClass}" data-action="${i}">
                            ${i + 1}
                        </button>`;
                    }

                    // Next Button
                    let nextDisabled = currentPage === totalPages - 1;
                    let nextClass = nextDisabled 
                        ? 'bg-[#d62828]/50 text-white cursor-not-allowed' 
                        : 'bg-[#d62828] text-white hover:bg-[#b02121] cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] transition ${nextClass}" data-action="next" ${nextDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </button>`;
                }

                $('#custom-dt-pagination').html(paginationHtml);
            }
        });

        // Initialize column visibility
        toggleBatchColumn("{{ request('role', 'siswa') }}");

        function toggleBatchColumn(role) {
            if (role === 'siswa') {
                table.column(3).visible(true); // Index 3 is Batch
                $('#th-batch').show();
            } else {
                table.column(3).visible(false);
                $('#th-batch').hide();
            }
        }

        $('#batch-filter').on('change', function() { table.draw(); });
        $('#dt-search').on('keyup', function() { table.draw(); });
        $('#custom-dt-length').on('change', function() { table.page.len($(this).val()).draw(); });
        
        // Dynamic Pagination Click Event
        $('#custom-dt-pagination').on('click', '.dt-paginate-btn', function() {
            let action = $(this).data('action');
            if (action !== undefined) {
                if (action === 'previous') {
                    table.page('previous').draw('page');
                } else if (action === 'next') {
                    table.page('next').draw('page');
                } else {
                    table.page(parseInt(action)).draw('page');
                }
            }
        });
    });
</script>
@endpush

</div>
@endsection
