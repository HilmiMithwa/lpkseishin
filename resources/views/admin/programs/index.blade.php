@extends('layouts.admin')

@section('title', 'Manajemen Program - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ 
    showAdd: false, 
    showEdit: false, 
    editForm: { batches: [] },
    allBatches: {{ Js::from($allBatches) }},
    confirmSubmit(event) {
        let movingBatches = false;
        this.editForm.batches.forEach(batchId => {
            let batch = this.allBatches.find(b => b.id_batch == batchId);
            if (batch && batch.id_program && batch.id_program != this.editForm.id_program) {
                movingBatches = true;
            }
        });
        
        if (movingBatches) {
            if (confirm('Beberapa batch yang Anda pilih saat ini terhubung dengan program lain. Anda yakin ingin memindahkannya ke program ini?')) {
                event.target.submit();
            }
        } else {
            event.target.submit();
        }
    }
}">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-[28px] lg:text-[32px] font-bold font-ibm text-[#0f172a] tracking-tight mb-2">Manajemen Program</h1>
            <p class="text-slate-500 text-[15px] font-medium">Kelola daftar program penyaluran yang tersedia di LPK.</p>
        </div>
        
        <button @click="showAdd = true" class="bg-[#d62828] text-white font-bold text-sm px-6 py-3 rounded-2xl hover:bg-[#b01e1e] transition-colors shadow-sm flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Program Baru
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200 font-medium">
        {{ session('success') }}
    </div>
    @endif

    @php
        $colorMap = [
            'rose' => ['bg' => 'bg-rose-50', 'hoverBg' => 'group-hover:bg-rose-100', 'text' => 'text-[#d62828]', 'border' => 'border-rose-100'],
            'blue' => ['bg' => 'bg-blue-50', 'hoverBg' => 'group-hover:bg-blue-100', 'text' => 'text-blue-600', 'border' => 'border-blue-200'],
            'emerald' => ['bg' => 'bg-emerald-50', 'hoverBg' => 'group-hover:bg-emerald-100', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100'],
            'indigo' => ['bg' => 'bg-indigo-50', 'hoverBg' => 'group-hover:bg-indigo-100', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100'],
            'slate' => ['bg' => 'bg-slate-50', 'hoverBg' => 'group-hover:bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-100'],
            'amber' => ['bg' => 'bg-amber-50', 'hoverBg' => 'group-hover:bg-amber-100', 'text' => 'text-amber-600', 'border' => 'border-amber-100'],
            'cyan' => ['bg' => 'bg-cyan-50', 'hoverBg' => 'group-hover:bg-cyan-100', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100'],
        ];
    @endphp

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($programs as $program)
        @php
            $c = $colorMap[$program->theme_color] ?? $colorMap['blue'];
            $isActive = filter_var($program->is_active, FILTER_VALIDATE_BOOLEAN);
        @endphp
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 flex flex-col h-full relative overflow-hidden group {{ !$isActive ? 'opacity-75' : '' }}">
            <div class="absolute -right-12 -top-12 w-40 h-40 {{ $c['bg'] }} rounded-full blur-3xl opacity-50 {{ $c['hoverBg'] }} transition-colors"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-5">
                    <div class="w-12 h-12 rounded-2xl {{ $c['bg'] }} flex items-center justify-center {{ $c['text'] }} {{ $c['border'] }} shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    @if($isActive)
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full border border-green-200">Aktif</span>
                    @else
                    <span class="bg-slate-100 text-slate-500 text-[11px] font-bold px-3 py-1 rounded-full border border-slate-200">Tidak Aktif</span>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-[#0f172a] mb-2 tracking-tight">{{ $program->nama }}</h3>
                <p class="text-slate-500 text-[13.5px] leading-relaxed mb-6 flex-grow">
                    {{ $program->deskripsi }}
                </p>
                
                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100/60 {{ !$isActive ? 'opacity-60' : '' }}">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Batch Aktif
                        </span>
                        <span class="font-bold {{ !$isActive ? 'text-slate-500' : 'text-[#0f172a]' }} text-[14px]">{{ $program->active_batches_count }} Batch</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Total Siswa
                        </span>
                        <span class="font-bold {{ !$isActive ? 'text-slate-500' : 'text-[#0f172a]' }} text-[14px]">{{ $program->total_students }} Siswa</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-auto pt-2">
                    <button @click="editForm = {{ $program->toJson() }}; editForm.batches = {{ $program->batches->pluck('id_batch')->toJson() }}; showEdit = true;" class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold text-[13px] py-2.5 rounded-[16px] hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                        Edit Detail
                    </button>
                    <form action="{{ route('admin.programs.destroy', $program->id_program) }}" method="POST" class="flex items-center justify-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-11 h-11 flex items-center justify-center bg-white border {{ $isActive ? 'border-rose-200 text-rose-500 hover:bg-rose-50' : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }} rounded-[16px] transition-colors shadow-sm" title="{{ $isActive ? 'Nonaktifkan Program' : 'Aktifkan Program' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($isActive)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                @endif
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modals -->
    <!-- Modal Tambah -->
    <div x-show="showAdd" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div x-show="showAdd" @click.away="showAdd = false" class="bg-white rounded-[24px] w-full max-w-lg mx-4 shadow-xl overflow-hidden transform transition-all">
            <form action="{{ route('admin.programs.store') }}" method="POST">
                @csrf
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-[#222222]">Tambah Program Baru</h3>
                    <button type="button" @click="showAdd = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program</label>
                        <input type="text" name="nama" required class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tema Warna</label>
                        <select name="theme_color" class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm">
                            <option value="rose">Rose (Merah)</option>
                            <option value="blue">Blue (Biru)</option>
                            <option value="emerald">Emerald (Hijau)</option>
                            <option value="indigo">Indigo (Ungu)</option>
                            <option value="amber">Amber (Kuning)</option>
                            <option value="slate">Slate (Abu-abu)</option>
                            <option value="cyan">Cyan (Sian)</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50">
                    <button type="button" @click="showAdd = false" class="px-6 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-900">Batal</button>
                    <button type="submit" class="bg-[#d62828] text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-[#b01e1e] transition-colors">Simpan Program</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="showEdit" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div x-show="showEdit" @click.away="showEdit = false" class="bg-white rounded-[24px] w-full max-w-lg mx-4 shadow-xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
            <form :action="'{{ url('/admin/programs') }}/' + editForm.id_program" method="POST" @submit.prevent="confirmSubmit($event)" class="flex flex-col h-full">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-[#222222]">Edit Program</h3>
                    <button type="button" @click="showEdit = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program</label>
                        <input type="text" name="nama" x-model="editForm.nama" required class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" x-model="editForm.deskripsi" rows="3" class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tema Warna</label>
                        <select name="theme_color" x-model="editForm.theme_color" class="w-full rounded-xl border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] shadow-sm">
                            <option value="rose">Rose (Merah)</option>
                            <option value="blue">Blue (Biru)</option>
                            <option value="emerald">Emerald (Hijau)</option>
                            <option value="indigo">Indigo (Ungu)</option>
                            <option value="amber">Amber (Kuning)</option>
                            <option value="slate">Slate (Abu-abu)</option>
                            <option value="cyan">Cyan (Sian)</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Batch untuk Program ini</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="batch in allBatches" :key="batch.id_batch">
                                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors" :class="{'bg-rose-50 border-rose-200': editForm.batches.includes(batch.id_batch)}">
                                    <input type="checkbox" name="batches[]" :value="batch.id_batch" x-model="editForm.batches" class="mt-0.5 rounded text-[#d62828] focus:ring-[#d62828]">
                                    <div class="flex-1">
                                        <div class="font-bold text-sm text-gray-900" x-text="batch.nama || 'Batch #' + batch.id_batch"></div>
                                        <div class="text-xs text-gray-500 mt-1" x-show="batch.program && batch.program.id_program != editForm.id_program">
                                            Saat ini terhubung di: <span class="font-semibold" x-text="batch.program.nama"></span>
                                        </div>
                                    </div>
                                </label>
                            </template>
                            <div x-show="allBatches.length === 0" class="text-sm text-gray-500 italic">Belum ada batch yang tersedia.</div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50">
                    <button type="button" @click="showEdit = false" class="px-6 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-900">Batal</button>
                    <button type="submit" class="bg-[#d62828] text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-[#b01e1e] transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
