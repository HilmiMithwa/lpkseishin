@extends('layouts.teacher')

@section('title', 'Periksa Kiriman - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{
    activeStudent: {{ $submissions->first()['id'] ?? 'null' }},
    students: {{ json_encode($submissions) }}
}">

    <!-- Header Row: Title + Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.assignments') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Periksa Kiriman</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.assignments') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Manajemen Tugas</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">{{ $tugas->judul_tugas }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2 self-start mt-1">
            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-2 rounded-xl text-sm font-bold shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Tenggat: {{ \Carbon\Carbon::parse($tugas->waktu_pengumpulan)->translatedFormat('d M Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Column: Student List -->
        <div class="lg:col-span-4 xl:col-span-3 flex flex-col gap-4">
            <!-- Search -->
            <div class="bg-white p-4 rounded-[24px] border border-gray-100 shadow-sm">
                <div class="relative">
                    <input type="text" placeholder="Cari nama siswa..." class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm font-semibold text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- List -->
            <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Pengumpulan ({{ $submissions->count() }})</h3>
                </div>
                <div class="p-2 space-y-1 max-h-[600px] overflow-y-auto custom-scrollbar">
                    <template x-for="student in students" :key="student.id">
                        <button @click="activeStudent = student.id" class="w-full text-left p-3 rounded-xl transition-all flex items-center gap-3 border"
                            :class="activeStudent === student.id ? 'bg-red-50/50 border-red-100 shadow-[0_2px_10px_-4px_rgba(214,40,40,0.2)]' : 'bg-transparent border-transparent hover:bg-gray-50'">
                            <!-- Avatar -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0"
                                :class="activeStudent === student.id ? 'bg-[#d62828] text-white' : 'bg-gray-100 text-gray-600'" x-text="student.avatar">
                            </div>
                            <!-- Info -->
                            <div class="flex-1 overflow-hidden">
                                <p class="font-bold text-sm truncate transition-colors" :class="activeStudent === student.id ? 'text-[#d62828]' : 'text-gray-800'" x-text="student.name"></p>
                                
                                <!-- Status Badge -->
                                <div class="mt-1 flex items-center">
                                    <span x-show="student.status === 'belum_dinilai'" class="text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-md border border-gray-200">Menunggu Penilaian</span>
                                    <span x-show="student.status === 'selesai'" class="text-[10px] font-bold text-gray-800 bg-white px-2 py-0.5 rounded-md border border-gray-200 shadow-sm flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Dinilai: <span x-text="student.score"></span>
                                    </span>
                                    <span x-show="student.status === 'terlambat'" class="text-[10px] font-bold text-[#d62828] bg-red-50 px-2 py-0.5 rounded-md border border-red-100">Terlambat</span>
                                    <span x-show="student.status === 'belum_kumpul'" class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md border border-gray-100">Belum Kumpul</span>
                                </div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Column: Grading Area -->
        <div class="lg:col-span-8 xl:col-span-9 flex flex-col gap-6">
            <template x-for="student in students" :key="student.id">
                <div x-show="activeStudent === student.id" class="space-y-6">
                    
                    <!-- Submission Details Card -->
                    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center font-bold text-xl text-gray-600" x-text="student.avatar"></div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800" x-text="student.name"></h2>
                                    <p class="text-sm font-semibold text-gray-500 mt-0.5 flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Dikirim: <span x-text="student.submitted_at"></span>
                                    </p>
                                </div>
                            </div>
                            <div x-show="student.status === 'selesai'" class="bg-white text-gray-800 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 border border-gray-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Nilai: <span x-text="student.score"></span>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div x-show="student.notes !== ''" class="bg-gray-50 border border-gray-200 rounded-2xl p-4 mb-6 flex gap-3 items-start">
                            <div class="mt-0.5 text-gray-400 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-500 tracking-wider mb-1">CATATAN SISWA:</p>
                                <p class="text-sm font-semibold text-gray-800 leading-relaxed" x-text="student.notes"></p>
                            </div>
                        </div>

                        <!-- Attachment Viewer -->
                        <div class="bg-gray-50 border border-gray-100 rounded-[24px] overflow-hidden min-h-[300px] flex items-center justify-center relative">
                            
                            <!-- Unsubmitted -->
                            <div x-show="student.status === 'belum_kumpul'" class="text-center p-8">
                                <div class="w-16 h-16 bg-white border border-gray-200 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800">Siswa Belum Mengumpulkan</h4>
                            </div>

                            <!-- Submitted Attachment (Unified Design for Backend) -->
                            <div x-show="student.status !== 'belum_kumpul'" class="w-full p-4 sm:p-6 flex flex-col justify-center items-center">
                                
                                <div class="w-full max-w-2xl bg-white border border-gray-200 rounded-[24px] p-4 shadow-sm flex flex-col gap-4">
                                    
                                    <!-- Dynamic Preview Area -->
                                    <div class="w-full bg-gray-50 rounded-[16px] border border-gray-100 flex items-center justify-center relative overflow-hidden min-h-[280px]">
                                        
                                        <!-- Image Preview -->
                                        <template x-if="student.attachment && student.attachment.type === 'image'">
                                            <img :src="student.attachment.url" alt="Tugas" class="max-h-[350px] object-contain">
                                        </template>

                                        <!-- Audio Preview -->
                                        <template x-if="student.attachment && student.attachment.type === 'audio'">
                                            <div class="flex flex-col items-center justify-center w-full p-8">
                                                <div class="w-16 h-16 bg-white shadow-sm border border-gray-100 text-gray-500 rounded-full flex items-center justify-center mb-6">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                                </div>
                                                <audio controls class="w-full max-w-sm">
                                                    <source src="#" type="audio/mpeg">
                                                </audio>
                                            </div>
                                        </template>

                                        <!-- Document Preview -->
                                        <template x-if="student.attachment && student.attachment.type === 'document'">
                                            <div class="flex flex-col items-center justify-center w-full p-8 text-gray-400">
                                                <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span class="text-sm font-semibold text-gray-500">Pratinjau dokumen tidak tersedia</span>
                                            </div>
                                        </template>
                                        
                                    </div>

                                    <!-- Consistent File Info & Action -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-2">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h4 class="font-bold text-gray-800 text-sm truncate" x-text="student.attachment ? student.attachment.name : 'File Tugas'"></h4>
                                                <p class="text-[11px] font-semibold text-gray-500 mt-0.5 uppercase tracking-wide" x-text="student.attachment && student.attachment.type === 'document' ? student.attachment.size : 'Diunggah oleh siswa'"></p>
                                            </div>
                                        </div>
                                        <a :href="'/submissions/' + student.id + '/download'" target="_blank" class="w-full sm:w-auto bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-colors flex items-center justify-center gap-2 text-sm flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh File
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grading Form Card -->
                    <form method="POST" :action="'{{ url('teacher/submissions') }}/' + student.id + '/grade'" class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-6 sm:p-8">
                        @csrf
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            Form Penilaian
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Input Skor -->
                            <div class="md:col-span-4 space-y-1.5">
                                <x-input-label>Berikan Skor (0-100)</x-input-label>
                                <x-text-input name="nilai" type="number" min="0" max="100" x-bind:value="student.score" required class="w-full text-3xl font-bold font-ibm rounded-2xl px-6 py-5 text-center" placeholder="0" />
                            </div>

                            <!-- Input Feedback -->
                            <div class="md:col-span-8 space-y-1.5">
                                <x-input-label>Catatan / Feedback Sensei</x-input-label>
                                <textarea name="feedback" x-text="student.feedback" rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm resize-none" placeholder="Tuliskan evaluasi atau koreksi untuk siswa..."></textarea>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3">
                            <x-primary-button type="submit" class="justify-center gap-2 py-3 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Nilai
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
