@extends('layouts.teacher')

@section('title', $evaluasi->judul . ' - Detail Evaluasi')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">

    {{-- Header Row --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">{{ $evaluasi->judul }}</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.batch.show', $batchId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $batchName }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.subjects.show', $mapelId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $className }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Modul {{ $moduleIndex }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-bold">{{ $evaluasi->judul }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 self-start">
            <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $evaluasi->id_evaluasi }}, name: '{{ addslashes($evaluasi->judul) }}', type: 'Evaluasi' })" class="inline-flex items-center gap-2 bg-white border border-red-200 hover:bg-red-50 text-[#d62828] font-bold font-karla py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm">
                Hapus
            </button>
            <button onclick="alert('Fitur edit evaluasi akan segera hadir!')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm">
                Edit Evaluasi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @php
            $visibleQuestions = $evaluasi->questions->filter(function($q) use ($evaluasi) {
                if ($evaluasi->tipe === 'Multiple Choice Only' && $q->tipe_soal === 'essay') return false;
                if ($evaluasi->tipe === 'Essay Only' && $q->tipe_soal === 'mcq') return false;
                return true;
            });
        @endphp
        
        {{-- Left Column (Spans 2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Soal Section --}}
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-lg sm:text-xl font-bold font-ibm text-gray-900">Daftar Soal</h2>
                    <span class="px-3 py-1 bg-red-50 text-[#d62828] text-xs font-bold rounded-lg">{{ $visibleQuestions->count() }} Soal Total</span>
                </div>

                <div class="space-y-6">
                    @php $displayIndex = 1; @endphp
                    @foreach($evaluasi->questions as $index => $q)
                    @if($evaluasi->tipe === 'Multiple Choice Only' && $q->tipe_soal === 'essay')
                        @continue
                    @endif
                    @if($evaluasi->tipe === 'Essay Only' && $q->tipe_soal === 'mcq')
                        @continue
                    @endif
                    <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 text-[#d62828] flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                    {{ $displayIndex++ }}
                                </div>
                                <div class="mt-1">
                                    <span class="text-xs font-bold font-karla px-2 py-0.5 rounded {{ $q->tipe_soal === 'mcq' ? 'bg-red-50 text-red-600' : 'bg-orange-50 text-orange-600' }} uppercase tracking-wider mb-2 inline-block">
                                        {{ $q->tipe_soal === 'mcq' ? 'Pilihan Ganda' : 'Esai' }}
                                    </span>
                                    <p class="text-gray-800 font-karla font-medium leading-relaxed">{!! nl2br(e($q->pertanyaan)) !!}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Images if any --}}
                        @if($q->images->count() > 0)
                        <div class="pl-11 grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                            @foreach($q->images as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="rounded-xl border border-gray-200 object-cover w-full h-32" alt="Image">
                            @endforeach
                        </div>
                        @endif

                        {{-- Options if MCQ --}}
                        @if($q->tipe_soal === 'mcq' && !empty($q->pilihan))
                        <div class="pl-11 grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                            @foreach($q->pilihan as $idx => $opt)
                            <div class="p-3 rounded-xl border {{ (string)$q->kunci_jawaban === (string)$idx ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200' }} flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ (string)$q->kunci_jawaban === (string)$idx ? 'bg-green-200 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ chr(65 + $idx) }}
                                </div>
                                <span class="{{ (string)$q->kunci_jawaban === (string)$idx ? 'text-green-800 font-bold' : 'text-gray-600' }} text-sm">{{ $opt }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column (Spans 1/3) --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Info Card --}}
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 shadow-sm sticky top-6">
                <h3 class="text-sm sm:text-base font-bold font-ibm text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Evaluasi</h3>
                
                <div class="space-y-4">
                    <div class="flex flex-col">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tipe Evaluasi</span>
                        <div class="flex items-center gap-2 text-gray-800 font-medium font-karla">
                            <svg class="w-4 h-4 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            {{ $evaluasi->tipe }}
                        </div>
                    </div>
                    
                    <div class="flex flex-col">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Durasi Pengerjaan</span>
                        <div class="flex items-center gap-2 text-gray-800 font-medium font-karla">
                            <svg class="w-4 h-4 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $evaluasi->durasi_menit }} Menit
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Bahasa Pengantar</span>
                        <div class="flex items-center gap-2 text-gray-800 font-medium font-karla">
                            <svg class="w-4 h-4 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            {{ $evaluasi->bahasa ?: 'Tidak ditentukan' }}
                        </div>
                    </div>
                </div>

                @if(!empty($evaluasi->panduan))
                <div class="mt-6 pt-5 border-t border-gray-100">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 block">Panduan Pengerjaan</span>
                    <ul class="space-y-2">
                        @foreach($evaluasi->panduan as $guide)
                        <li class="flex items-start gap-2 text-sm text-gray-600 font-karla">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-relaxed">{{ $guide }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('modals')
{{-- Delete Item Modal --}}
<div x-data="{ 
        open: false, 
        itemId: null, 
        itemName: '', 
        itemType: '', 
        isLoading: false,
        deleteUrl: ''
     }" 
     x-show="open" 
     x-on:open-delete-item-modal.window="
        itemId = $event.detail.id; 
        itemName = $event.detail.name; 
        itemType = $event.detail.type; 
        if (itemType === 'Evaluasi') {
            deleteUrl = '{{ url('/teacher/modules/' . $id_modul . '/evaluations') }}/' + itemId;
        }
        open = true;
     "
     style="display: none;"
     class="fixed inset-0 z-[110] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <div x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
         @click="open = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6 sm:p-8">
             
             <div class="sm:flex sm:items-start gap-5">
                 <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-12 sm:w-12">
                     <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                     </svg>
                 </div>
                 <div class="mt-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                     <h3 class="text-xl font-bold font-ibm text-gray-900" id="modal-title">Hapus <span x-text="itemType"></span></h3>
                     <div class="mt-2">
                         <p class="text-sm font-karla text-gray-500 leading-relaxed">Apakah Anda yakin ingin menghapus <span class="font-bold text-gray-700" x-text="itemName"></span>? Tindakan ini tidak dapat dikembalikan.</p>
                     </div>
                 </div>
             </div>
             
             <div class="mt-8 sm:mt-6 sm:flex sm:flex-row-reverse gap-3">
                 <form :action="deleteUrl" method="POST" class="m-0" @submit="isLoading = true">
                     @csrf
                     @method('DELETE')
                     <button type="submit" :disabled="isLoading" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold font-karla text-white shadow-sm hover:bg-red-500 sm:w-auto transition items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                         <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                         <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                     </button>
                 </form>
                 <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold font-karla text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">Batal</button>
             </div>
        </div>
    </div>
</div>
@endpush

@endsection
