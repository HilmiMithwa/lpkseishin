@extends('layouts.teacher')

@section('title', 'Manajemen Tugas - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ 
    activeTab: 'belum_diperiksa', 
    showCreateModal: false,
    isEditMode: false,
    editTaskId: null,
    
    taskTitle: '',
    taskDueDate: '',
    taskDesc: '',
    selectedBatch: '',
    selectedClass: '',
    selectedModule: '',
    
    showDeleteModal: false,
    deleteTaskId: null,
    deleteTaskTitle: '',

    batchesData: {{ json_encode($batches) }},
    classesData: {{ json_encode($classes) }},
    modulesData: {{ json_encode($allModules) }},
    get filteredClasses() {
        if (!this.selectedBatch) return [];
        return this.classesData.filter(c => c.id_batch == this.selectedBatch);
    },
    get filteredModules() {
        if (!this.selectedClass) return [];
        return this.modulesData.filter(m => m.id_mapel == this.selectedClass);
    },
    openCreateModal() {
        this.isEditMode = false;
        this.editTaskId = null;
        this.taskTitle = '';
        this.taskDueDate = '';
        this.taskDesc = '';
        this.selectedBatch = '';
        this.selectedClass = '';
        this.selectedModule = '';
        this.showCreateModal = true;
    },
    openEditModal(id, title, dueDate, desc, batchId, classId, moduleId) {
        this.isEditMode = true;
        this.editTaskId = id;
        this.taskTitle = title;
        this.taskDueDate = dueDate ? dueDate.replace(' ', 'T').substring(0, 16) : '';
        this.taskDesc = desc || '';
        this.selectedBatch = batchId;
        this.selectedClass = classId;
        this.$nextTick(() => {
            this.selectedModule = moduleId;
        });
        this.showCreateModal = true;
    },
    openDeleteModal(id, title) {
        this.deleteTaskId = id;
        this.deleteTaskTitle = title;
        this.showDeleteModal = true;
    }
}">

    <!-- Header & Action -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-left">
        <div>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Manajemen Tugas</h1>
            <p class="text-sm text-[#666666] font-medium mt-1">Kelola penugasan dan periksa hasil pekerjaan siswa.</p>
        </div>
        <button @click="openCreateModal()" class="h-fit inline-flex items-center justify-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-sm whitespace-nowrap self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Buat Tugas Baru
        </button>
    </div>

    <!-- Filter Section (Select Batch & Class) -->
    <form method="GET" action="{{ route('teacher.assignments') }}" class="bg-white rounded-[24px] border border-gray-100 p-5 shadow-sm grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <!-- Custom Dropdown Batch -->
        <div class="space-y-1.5" x-data="{ 
            open: false, 
            selectOption(val) { 
                $refs.input.value = val; 
                $refs.input.form.submit(); 
            } 
        }">
            <x-input-label>Pilih Batch</x-input-label>
            <div class="relative">
                <input type="hidden" name="batch_id" x-ref="input" value="{{ $selectedBatchId }}">
                
                <div @click="open = !open" 
                     class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-bold text-gray-900 cursor-pointer flex justify-between items-center transition"
                     :class="open ? 'border-[#d62828] ring-1 ring-[#d62828]' : 'border-gray-200 hover:border-[#d62828]'">
                    <span>
                        @if($selectedBatchId)
                            {{ $batches->firstWhere('id_batch', $selectedBatchId)->nama ?? 'Semua Batch' }}
                        @else
                            Semua Batch
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div x-show="open" @click.outside="open = false" style="display: none;"
                     x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                    <ul class="py-1">
                        <li>
                            <div @click="selectOption('')" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer {{ $selectedBatchId == '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]' }} transition-colors">
                                Semua Batch
                            </div>
                        </li>
                        @foreach($batches as $batch)
                        <li>
                            <div @click="selectOption('{{ $batch->id_batch }}')" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer {{ $selectedBatchId == $batch->id_batch ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]' }} transition-colors">
                                {{ $batch->nama }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Custom Dropdown Kelas -->
        <div class="space-y-1.5" x-data="{ 
            open: false, 
            selectOption(val) { 
                $refs.input.value = val; 
                $refs.input.form.submit(); 
            } 
        }">
            <x-input-label>Pilih Kelas</x-input-label>
            <div class="relative">
                <input type="hidden" name="mapel_id" x-ref="input" value="{{ $selectedMapelId }}">
                
                <div @click="open = !open" 
                     class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-bold text-gray-900 cursor-pointer flex justify-between items-center transition"
                     :class="open ? 'border-[#d62828] ring-1 ring-[#d62828]' : 'border-gray-200 hover:border-[#d62828]'">
                    <span>
                        @if($selectedMapelId)
                            {{ $classes->firstWhere('id_mapel', $selectedMapelId)->nama_mapel ?? 'Semua Kelas' }}
                        @else
                            Semua Kelas
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div x-show="open" @click.outside="open = false" style="display: none;"
                     x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                    <ul class="py-1">
                        <li>
                            <div @click="selectOption('')" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer {{ $selectedMapelId == '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]' }} transition-colors">
                                Semua Kelas
                            </div>
                        </li>
                        @foreach($classes as $class)
                        <li>
                            <div @click="selectOption('{{ $class->id_mapel }}')" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer {{ $selectedMapelId == $class->id_mapel ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]' }} transition-colors">
                                {{ $class->nama_mapel }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </form>


    <!-- Main Content -->
    <div>
        
        <!-- Tab Navigation -->
        <div class="flex items-end gap-4 mb-6 border-b border-gray-200 overflow-x-auto custom-scrollbar">
            <button @click="activeTab = 'belum_diperiksa'" :class="activeTab === 'belum_diperiksa' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition flex items-center gap-2">
                Belum Diperiksa
                <span class="bg-[#d62828] text-white text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $belumDiperiksa->count() }}</span>
            </button>
            <button @click="activeTab = 'aktif'" :class="activeTab === 'aktif' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition flex items-center gap-1">
                Aktif berjalan
                @if($aktifBerjalan->count() > 0)
                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ $aktifBerjalan->count() }}</span>
                @endif
            </button>
            <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition flex items-center gap-1">
                Selesai
                @if($selesai->count() > 0)
                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ $selesai->count() }}</span>
                @endif
            </button>
        </div>

        <!-- Tab 1: Belum Diperiksa -->
        <div x-show="activeTab === 'belum_diperiksa'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($belumDiperiksa->isEmpty())
            <div class="bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm min-h-[300px] flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mb-6 border-4 border-red-100/50">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Tugas</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">Saat ini tidak ada tugas yang perlu diperiksa atau dinilai.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($belumDiperiksa as $task)
                @include('teacher.partials.task-card', ['task' => $task])
                @endforeach
            </div>
            @endif
        </div>

        <!-- Tab 2: Aktif Berjalan -->
        <div x-show="activeTab === 'aktif'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($aktifBerjalan->isEmpty())
            <div class="bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak Ada Tugas Aktif</h3>
                <p class="text-sm text-gray-500 max-w-sm">Semua tugas sudah melewati masa tenggat waktu. Silakan buat tugas baru.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($aktifBerjalan as $task)
                @include('teacher.partials.task-card', ['task' => $task])
                @endforeach
            </div>
            @endif
        </div>

        <!-- Tab 3: Selesai -->
        <div x-show="activeTab === 'selesai'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            @if($selesai->isEmpty())
            <div class="bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm min-h-[300px] flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mb-6 border-4 border-red-100/50">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Tugas Selesai</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">Tugas yang sudah selesai diperiksa dan melewati batas waktu akan muncul di sini.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($selesai as $task)
                @include('teacher.partials.task-card', ['task' => $task])
                @endforeach
            </div>
            @endif
        </div>

    </div>

    <!-- Create Task Modal overlay -->
    <template x-teleport="body">
        <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6" x-cloak>
            <!-- Backdrop -->
            <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showCreateModal = false"></div>

        <!-- Modal Panel -->
        <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0" class="relative w-full max-w-2xl bg-white rounded-[32px] shadow-2xl overflow-hidden z-10 flex flex-col max-h-full">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold font-ibm text-[#222222]" x-text="isEditMode ? 'Edit Tugas' : 'Buat Tugas Baru'"></h3>
                    <p class="text-sm text-gray-500 mt-1" x-text="isEditMode ? 'Perbarui detail penugasan yang sudah ada.' : 'Isi detail tugas untuk diunggah ke kelas.'"></p>
                </div>
                <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-1 bg-gray-50/30">
                <form id="createAssignmentForm" :action="isEditMode ? '{{ url('/teacher/assignments') }}/' + editTaskId : '{{ route('teacher.assignments.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" x-bind:name="isEditMode ? '_method' : ''" x-bind:value="isEditMode ? 'PUT' : ''" :disabled="!isEditMode">
                    
                    <!-- Judul & Tenggat Waktu -->
                    <div class="space-y-5">
                        <div class="space-y-1.5">
                            <x-input-label>Judul Tugas</x-input-label>
                            <x-text-input type="text" name="judul_tugas" x-model="taskTitle" required placeholder="Misal: Menulis Kanji Bab 5" class="w-full" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Tenggat Waktu (Due Date)</x-input-label>
                            <x-text-input type="datetime-local" name="waktu_pengumpulan" x-model="taskDueDate" class="w-full" />
                        </div>
                    </div>

                    <!-- Target Kelas -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5" x-show="!isEditMode">
                        <x-input-label class="mb-3">Terbitkan Untuk Kelas & Modul</x-input-label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <div x-data="{ open: false }" class="relative">
                                    <input type="hidden" name="batch_id" x-model="selectedBatch" :required="!isEditMode">
                                    <div @click="open = !open" 
                                         class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-semibold cursor-pointer flex justify-between items-center transition"
                                         :class="open ? 'border-[#d62828] ring-2 ring-red-500/20' : 'border-gray-200 hover:border-[#d62828]'">
                                        <span class="text-gray-800" x-text="selectedBatch ? batchesData.find(b => b.id_batch == selectedBatch)?.nama : 'Pilih Batch...'"></span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="open" @click.outside="open = false" style="display: none;"
                                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            <li>
                                                <div @click="selectedBatch = ''; selectedClass = ''; selectedModule = ''; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedBatch === '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                    Pilih Batch...
                                                </div>
                                            </li>
                                            <template x-for="batch in batchesData" :key="batch.id_batch">
                                                <li>
                                                    <div @click="selectedBatch = batch.id_batch; selectedClass = ''; selectedModule = ''; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedBatch == batch.id_batch ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                        <span x-text="batch.nama"></span>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div x-data="{ open: false }" class="relative">
                                    <input type="hidden" name="class_id" x-model="selectedClass" :required="!isEditMode">
                                    <div @click="if(selectedBatch !== '') open = !open" 
                                         class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-semibold flex justify-between items-center transition"
                                         :class="selectedBatch === '' ? 'opacity-70 cursor-not-allowed border-gray-200' : (open ? 'border-[#d62828] ring-2 ring-red-500/20 cursor-pointer' : 'border-gray-200 hover:border-[#d62828] cursor-pointer')">
                                        <span class="text-gray-800" x-text="selectedClass ? filteredClasses.find(c => c.id_mapel == selectedClass)?.nama_mapel : 'Pilih Kelas...'"></span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="open" @click.outside="open = false" style="display: none;"
                                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            <li>
                                                <div @click="selectedClass = ''; selectedModule = ''; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedClass === '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                    Pilih Kelas...
                                                </div>
                                            </li>
                                            <template x-for="kelas in filteredClasses" :key="kelas.id_mapel">
                                                <li>
                                                    <div @click="selectedClass = kelas.id_mapel; selectedModule = ''; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedClass == kelas.id_mapel ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                        <span x-text="kelas.nama_mapel"></span>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div x-data="{ open: false }" class="relative">
                                    <input type="hidden" name="id_modul" x-model="selectedModule" :required="!isEditMode">
                                    <div @click="if(selectedClass !== '') open = !open" 
                                         class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-semibold flex justify-between items-center transition"
                                         :class="selectedClass === '' ? 'opacity-70 cursor-not-allowed border-gray-200' : (open ? 'border-[#d62828] ring-2 ring-red-500/20 cursor-pointer' : 'border-gray-200 hover:border-[#d62828] cursor-pointer')">
                                        <span class="text-gray-800" x-text="selectedModule ? filteredModules.find(m => m.id_modul == selectedModule)?.nama_modul : 'Pilih Modul...'"></span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="open" @click.outside="open = false" style="display: none;"
                                         class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                                        <ul class="py-1">
                                            <li>
                                                <div @click="selectedModule = ''; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedModule === '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                    Pilih Modul...
                                                </div>
                                            </li>
                                            <template x-for="modul in filteredModules" :key="modul.id_modul">
                                                <li>
                                                    <div @click="selectedModule = modul.id_modul; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-semibold cursor-pointer transition-colors" :class="selectedModule == modul.id_modul ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                        <span x-text="modul.nama_modul"></span>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] font-medium text-gray-500 mt-3">Tugas ini akan disematkan ke Modul yang dipilih pada kelas target.</p>
                    </div>

                    <!-- Target Kelas (Read-Only) -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5" x-show="isEditMode" style="display: none;">
                        <x-input-label class="mb-3">Lokasi Tugas</x-input-label>
                        <div class="flex items-center gap-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl px-4 py-3">
                            <span x-text="batchesData.find(b => b.id_batch == selectedBatch)?.nama || 'Memuat...'"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span x-text="classesData.find(c => c.id_mapel == selectedClass)?.nama_mapel || 'Memuat...'"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span x-text="modulesData.find(m => m.id_modul == selectedModule)?.nama_modul || 'Memuat...'"></span>
                        </div>
                        <p class="text-[10px] font-medium text-gray-500 mt-3">Lokasi penugasan tidak dapat diubah setelah diterbitkan.</p>
                        <input type="hidden" name="id_modul" :value="selectedModule" :disabled="!isEditMode">
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-1.5">
                        <x-input-label>Instruksi (Opsional)</x-input-label>
                        <textarea name="deskripsi_tugas" x-model="taskDesc" rows="3" placeholder="Tambahkan instruksi pengerjaan jika ada..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm"></textarea>
                    </div>

                    <!-- Upload -->
                    <div x-data="{ fileName: null, isDragging: false, removeResource: false }" class="space-y-1.5">
                        <x-input-label>Lampiran Soal / Materi (Opsional)</x-input-label>
                        
                        <!-- File Input (Hidden) -->
                        <input type="file" id="assignment_file" name="file_path_tugas" class="hidden" 
                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null; removeResource = false">
                        <input type="hidden" name="remove_resource" :value="removeResource ? '1' : '0'">
                               
                        <!-- Dropzone -->
                        <label for="assignment_file" 
                               @dragover.prevent="isDragging = true" 
                               @dragleave.prevent="isDragging = false"
                               @drop.prevent="isDragging = false; if($event.dataTransfer.files.length > 0) { document.getElementById('assignment_file').files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name; removeResource = false; }"
                               class="block border-2 border-dashed rounded-2xl p-6 transition-colors cursor-pointer group"
                               :class="isDragging ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white hover:border-red-300'">
                            <!-- State: No File -->
                            <div x-show="!fileName" class="text-center">
                                <div class="w-12 h-12 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700 mb-1">Klik untuk unggah atau seret file ke sini</p>
                                <p class="text-xs text-gray-500 font-medium">PDF, DOCX, JPG, PNG (Maks. 5MB)</p>
                            </div>
                            
                            <!-- State: File Selected -->
                            <div x-show="fileName" style="display: none;" class="flex items-center justify-between bg-white/50 rounded-xl p-2 border border-gray-100">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-10 h-10 bg-red-50 text-[#d62828] rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="text-left truncate">
                                        <p class="text-sm font-bold text-gray-800 truncate" x-text="fileName"></p>
                                        <p class="text-xs text-green-600 font-medium mt-0.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Siap diunggah
                                        </p>
                                    </div>
                                </div>
                                <button type="button" @click.prevent="fileName = null; document.getElementById('assignment_file').value = ''" class="text-red-400 hover:text-[#d62828] p-2 hover:bg-red-50 rounded-full transition-colors flex-shrink-0" title="Hapus file">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end gap-3 rounded-b-[32px] sticky bottom-0 z-20">
                <button @click="showCreateModal = false" type="button" class="px-5 py-2.5 rounded-xl font-bold text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <x-primary-button type="submit" form="createAssignmentForm" x-data="{ loading: false }" @click="loading = true" class="px-5 py-2.5 gap-2 shadow-sm">
                    <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <svg x-show="loading" class="w-4 h-4 animate-spin" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="loading ? 'Menyimpan...' : (isEditMode ? 'Simpan Perubahan' : 'Terbitkan Tugas')"></span>
                </x-primary-button>
            </div>
            
        </div>
        </div>
    </template>

    <!-- Delete Modal -->
    <template x-teleport="body">
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showDeleteModal = false"></div>
            <div x-show="showDeleteModal" x-transition.scale.95 class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden z-10 flex flex-col">
                <div class="px-6 py-8 text-center flex-1">
                    <div class="w-16 h-16 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100/50">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold font-ibm text-gray-900 mb-2">Hapus Tugas?</h3>
                    <p class="text-sm text-gray-500 font-medium mb-6">Tugas "<span x-text="deleteTaskTitle" class="font-bold text-gray-800"></span>" beserta seluruh data akan dihapus permanen.</p>
                    <form id="deleteAssignmentForm" :action="'{{ url('/teacher/assignments') }}/' + deleteTaskId" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="showDeleteModal = false" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold transition">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-[#d62828] hover:bg-red-700 text-white rounded-xl font-bold shadow-sm transition">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection
